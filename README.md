# Endpoints
## Users
### Register
POST <code>/api/auth/register</code>

#### Payload:

<code>product_name</code>: <code>required|string</code>

<code>email</code>: <code>required|string</code>

<code>password</code>: <code>required|string</code>
### Login
POST <code>/api/auth/login</code>
#### Payload:

<code>email</code>: <code>required|string</code>

<code>password</code>: <code>required|string</code>

## Orders
### Create Order
POST <code>/api/orders</code>
#### Payload:

<code>product_name</code>: <code>required|string</code>

<code>amount</code>: <code>required|numeric</code>

<code>status</code>: <code>required|in:новый,в обработке,отправлен,доставлен</code>


### Get All Orders
GET
<code>/api/orders</code>

#### Payload:

<code>per_page</code>: <code>number</code>

<code>page</code>: <code>number</code>

#### Response:
Returns a paginated list of all orders.

### Get an Order by ID
GET
<code>/api/orders/{order}</code>

#### Response:
Returns a queried order.

### Update an order

#### Payload:

<code>product_name</code>: <code>sometimes|string</code>

<code>amount</code>: <code>sometimes|numeric</code>

<code>status</code>: <code>sometimes|string</code> allowed values: <code>new, in_progress, sent, delivered</code>

#### Response:
Updates a property of an order and returns a full updated order model.

### Delete an Order
DELETE <code>/api/orders/{order}</code>

#### Response:
Deletes the specified order and returns a 204 No Content status.
