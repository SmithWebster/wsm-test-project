# WSM EUROPA test project

## Preconditions

### Technical
You need at least:

* PHP 5.3 or higher
* A text editor or IDE of your choice
* Some kind of shell, if you want to write unit tests (optionally).

### Knowledge
You will be tested within the following areas of PHP development:

* Basic understanding of PHP's OOP implementation.
* Namespaces, Closures/Anonymous functions
* Reading resources from a local file system location
* Coping with JSON as data format

## The tasks
With this code you will receive a number of tasks to resolve. Each task should
not take more then 15 to 30 minutes pure working time.

### Implement a basic OrderService

Implement the interface for the Order Service. Please use the JSON file in the data directory as your datasource. 
Your implementation must read the resultset from the datasource and pass the values from the json file into the corresponding classes from the Entity namespace. 

The entities encapsulate each other in the following way:

(Order) -[hasMany]-> (Item)
(Order) -[hasOne]-> (Discount)

The JSON file has a similar structure. Please take a deep look at both structures

### Implement a basic ItemService

Implement the interface for the Item Service. Think about adding a sorting function to sort items by name, price, quantity or weight.
The implementation should be used in initializing the Order Entity model.

### Visualize the data

Using your implementations for the Order Service and the Item Service display following data on the screen
- List of the pending orders. Example format: ID, Status, Number of ordered items, Total, Shipping method, Date.
- Details for order #100000081. This should contain all information about purchased items, applied discounts, etc.

You are not required to use any visualisation tools or advanced front-end techniques to complete this task.
The main point is to display the data in a clear format.
