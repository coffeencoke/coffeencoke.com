I often like to do exercises on my own to continue developing the skill of designing solutions and thinking through problems, and edge cases. I also do this so that I can use these exercises for when I give interviews for others. One problem that I really like, is the Elevator problem. 

This problem develops or reveals abilities for the following:

* Abstract problem solving
* Object Oriented and Functional Design Principles
* Restful Design Principles
* Edge case considerations
* Ability to communicate your decisions
* Changing your design to evolving requirements

All good items to look for when interviewing a candidate.


## The Problem Statement

Given an API to an elevator driver which controls the following basic functions of an elevator, write a Restful API to program the a set of user scenarios.

## Scenarios

These scenarios are from the user's perspective.  Each and every assertion can be made by what the user notices. Designing your software from this perspective allows you to first think about the user's experience, and to provide immediate value.

### Scenario 1: Open the door

```
Given the elevator is on the same floor
When I call for the elevator
Then the door opens so I can walk into the elevator
```

### Scenario 2: Call the elevator

```
Given the elevator is on a different floor
When I call for the elevator
Then the door opens so I can walk into the elevator
```

### Scenario 3: Go to a floor

```
Given I am on an elevator
When I tell the elevator to go to my desired floor
Then the door opens on my desired floor
And the door closes after I've left the elevator
```

### Scenario 4: Call an elevator that is on the move

```
Given the elevator is on the move going down
When I call for the elevator to go up
Then the elevator finishes its current job
And comes to me
And the door opens so I can walk into the elevator
```

## Elevator Driver APIs

There are four API methods for the `ElevatorDriver`.

* `ElevatorDriver.elevator`
* `ElevatorDriver.go_to_floor(floor_number)`
* `ElevatorDriver.open_door`
* `ElevatorDriver.close_door`
* `ElevatorDriver::Elevator#current_floor`
* `ElevatorDriver::Elevator#state`

### `ElevatorDriver.elevator`

Show details of the elevator. Returns an `ElevatorDriver::Elevator` object.

* `current_floor` - Returns the floor number that the elevator is currently on
* `state` - Returns one of `:moving_up`, `:moving_down`, or `:stagnant`, all three of which are `Symbol` types.

#### Example

```
elevator = ElevatorDriver.elevator    # => ElevatorDriver::Elevator instance
elevator.current_floor                # => 6
elevator.state                        # => :stagnant
```

### `ElevatorDriver.go_to_floor`

Tells the elevator to go to the given floor. Returns nothing. By default is synchronous, but can be given arguments to make it asynchronous. If the elevator is already in progress, this will force the elevator to stop its current action, and go to the floor that is given.

Arguments:

* `floor_number`, The floor for the elevator to go to.
* `async`, takes any of the following:
  * `true`, returns immediately.
  * `Lambda`, `Proc`, `Block`, used as a callback, after the elevator arrives at the given floor.
  
#### Example

```
# Returns true after the elevator has arrived at floor 6.
ElevatorDriver::Elevator.go_to_floor(6) 

# Go to floor 7
# Returns immediately
ElevatorDriver::Elevator.go_to_floor(7, async: true)

# Sends the elevator to the 5th floor
# Returns immediately
# Prints a message via `puts` when the elevator arrives at the 5th floor.
message = "Arrived at the 5th floor!"
lamb = -> { puts "Lamb: #{message}" }
proc = Proc.new { puts "Proc: #{message}" }

ElevatorDriver::Elevator.go_to_floor(5, &lamb)
ElevatorDriver::Elevator.go_to_floor(5, &proc)
ElevatorDriver::Elevator.go_to_floor(5) do 
  puts "Block: #{message}"
end
```

### Open door

This will tell the elevator and the elevator shaft to open its doors. *This is a synchronous request, and will return after the door has opened.*

#### Example

```
ElevatorDriver.open_door
```

### Close door

This will tell the elevator and the elevator shaft to close its doors. *This is a synchronous request, and will return after the door has closed.*

#### Example

```
ElevatorDriver.close_door
```

## Working Through The Problem

What I like to see is the thought process around the solution, so I'm going to walk through the problem that way.

### Scenario 1: Open the door

The first thing here is that we know we have to create a restful endpoint to allow the user to do what the user needs to do.  The action here, is to call the elevator.  

When the user presses the button to call the elevator, that button is going to make a Restful request, over HTTP (for this exercise). Because the request will change the state of the elevator, and because the object, that we want to make the request to, is known, this request should be a `PUT` request type, which might look like so:

```
PUT /elevator 
data: elevator[floor]=1
```

I like to use an endpoint that clearly describes the object that we are making a request to, in this case `elevator`, I also like to isolate the parameters that are being used to manipulate the elevator, that is why there is a namespace in the data for the elevator's floor.

The implementation of this endpoint should contain some sort of routing and controller to send the request to.  If we are using rails, this is easily done using the following:

`config/routes.rb`:

```
resource :elevator, only: :update
```

`app/controllers/elevators_controller.rb`:

```
class ElevatorsController < ActionController::Base
  def update
    elevator = $elevator
    elevator.call_to_floor(params[:elevator][:floor])
  end
end
```

Because we now know that we need a global variable `$elevator` available to the controller, we should add that to the initialization of the application for now. As our application grows, this can grow as well, but for now, an in memory variable will suffice.

`config/initializers/elevator.rb`:

```
$elevator = Elevator.new
```

This shows us that we need an `Elevator` class. The only API that this class has for now, is the `#call_to_floor` method, So let's add that to `app/models/elevator.rb`:

```
class Elevator
  def call_to_floor(floor_number)
    driver.open_door
  end
  
  protected
  
  def driver
    ::ElevatorDriver
  end
end
```

The only implementation we need for now, is to open the door, because in the first scenario, the elevator is already on my floor.

I've extracted the `::ElevatorDriver` to a protected method, so that no one else sends direct messages to the elevator's driver, and so that if I want to change the driver class, I only have to change in one place.

You can see here that I am encapsulating the `ElevatorDriver` class within my `Elevator` class.  I am doing this so that I can isolate any interactions my application has with the driver class.  That way, if the driver APIs change, or I want to use a different driver, then I only have to change the `Elevator` class and the rest of my application will not need to change! To read more about this, take a look at the [Open / Closed Principle](http://en.wikipedia.org/wiki/Open/closed_principle).  

If we wanted to take this to the next level to provide a more flexible application, and remove coupling of the ElevatorDriver's APIs, we could create an `ElevatorInterface` class, that would use an `ElevatorConfig` instance to configure which class driver it should use. The interface class would implement the use of the configured driver class, so that it could be swapped out with a new driver class without changing any source code.

This satisfies the requirements for Scenario 1.

### Scenario 2: Call the elevator

We already have an application that opens the door for us, now we just need to add the ability to call the elevator to my floor, for when the elevator is not yet on our floor.

There are a few things to consider for this implementation.  The `ElevatorDriver.go_to_floor` method can be synchronous, or asynchronous.  It can also take a callback, while being asynchronous.  So, let's go with the default to hash out the initial solution and see if that satisfies the scenario requirements, and then we can consider optimizing.

This implementation lives in the `Elevator` class alone:

`app/models/elevator.rb` changes to the following:

```
class Elevator
  def call_to_floor(floor_number)
    go_to_floor(floor_number)
    driver.open_door
  end
  
  protected
  
  def go_to_floor(floor_number)
    driver.go_to_floor(floor_number) unless on_floor?(floor_number)
  end
  
  def on_floor?(floor_number)
    elevator.current_floor == floor_number
  end
  
  def elevator
    driver.elevator
  end
  
  def driver
    ::ElevatorDriver
  end
end
```

By adding the methods `#go_to_floor`, `#on_floor?`, `#elevator`, we have provided the functionality to call the elevator in a synchronous way, and then to open the door when the elevator arrives.

In my opinion, the scenarios, thus far, do not provide any requirements that would make me consider making the implementation asynchronous to calling the elevator.

This finishes Scenario 2.

### Scenario 3: Go to a floor

Beautifully, the implementation for this is already complete from our current work.  The only difference, is instead of the user calling the elevator to come to my current floor, the user is telling the elevator to go to a specific floor.

So you can still use the following call:

```
PUT /elevator 
data: elevator[floor]=5
```

However, we do not yet have the following line in the scenario:

> And the door closes after I've left the elevator

Therefor, we need to make the door close after a while of waiting. Since this scenario does not say anything about how long to wait, let's make the best decision we can.  I think 5 seconds after the door is open, we can shut the door for now.

So let's change the `Elevator#call_to_floor` method and add the appropriate new methods to the `Elevator` class:

```
  def call_to_floor(floor_number)
    go_to_floor(floor_number)
    driver.open_door
    sleep 5
    driver.close_door
  end
```

## Wrap It Up

Now, I think there's obviously some work that could be done to push out how long to sleep, but I don't think it's necessary to do that for the first three scenarios.

I'm going to leave the fourth scenario up to you to play around with, see what you can get out of it, and learn from your decisions.

What's great about this exercise, is that its complexity can easily continue to grow by introducing the following things:

1. Multiple calls to the elevator on different floors
2. Efficiency on arriving to calls, ie. picking up for the same direction, and then looping back to pick up the opposite directions.
3. Providing an endpoint to get the status of an elevator, so buttons, or elevator floor indicators can be updated.
4. Adding multiple elevators.
5. Sharding the elevators, ie. elevator 1, 2, and 3 go to floors 1-20, and elevators 4, 5, and 6 go to floors 21-40.
6. Having the elevators rest at an efficient location, ie. When an elevator has not been in use for a full minute, it should rest in the middle of the floors, or if it's the end of a workday, the elevator should rest near the most populated office.
7. Machine learning, ie. Have the elevator learn about patterns of use, and anticipate for those patterns.

I'd love to hear what some interview exercises you like, and what you think about this one. Let me know what you think on [twitter](http://twitter.com/coffeencoke). Thanks for reading!