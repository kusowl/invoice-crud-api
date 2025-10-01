# CustomerInvoice CRUD API 
This is a toy project where i have explored how to built api in Laravel.

**Contents**

[Operators](#Operators)
[Endpoints](#Endpoints)

## Authentication
By Default it uses Laravel Santum for authentication, with three authorization levels.

|Levels|Abilites|
|:-----|:-----|
|  Level 3    |     Create, Update, Delete |
|  Level  2|      Create, Update|
|  Level 1  |  Read Only    |

You can get these tokens by visiting `/setup`, which will return these three tokens.
You have to pass one of these bearer token, with authentication header.

## Response

By deafult all results are paginated with 15 entries in each page. Response format is :-

```json
{
  "data" : [{...}, {...}],
  "links": {
    "first": ".../api/v1/customers?page=1",
    "last": "../api/v1/customers?page=5",
    "prev": ".../api/v1/customers?page=1",
    "next": ".../api/v1/customers?page=3"
  },
   "meta": {
    "current_page": 2,
    "from": 16,
    "last_page": 5,
    "links": [
      {
        "url": "http://localhost:8000/api/v1/customers?page=1",
        "label": "&laquo; Previous",
        "page": 1,
        "active": false
      },
      { ...},
      {
        "url": "http://localhost:8000/api/v1/customers?page=2",
        "label": "2",
        "page": 2,
        "active": true
      },
      {...},{...},{....},
      {
        "url": "http://localhost:8000/api/v1/customers?page=3",
        "label": "Next &raquo;",
        "page": 3,
        "active": false
      }
    ],
    "path": "http://localhost:8000/api/v1/customers",
    "per_page": 15,
    "to": 30,
    "total": 68
  }
}
```

## Operators

|Operator|Meaning|
|:-----|:-----|
|    =  |  equals to    |
|  nte    | not equals to (<>)     |
|      gt| greater than   (>)  |
|    lt  | lesser than (<)     |
|  gte    |  greater than or equal ( >=)     |
|     lte | lesser than or equal (<=)     |
| like | like |

**Usage**

Incase of *equals to*,

`<parameter>=<value>`

example, 

`name=Kushal`

Others operators,

`<parameter>[<operator>]=<value>`

example, 

`name[nte]=Kushal`

## Endpoints

This api is versionised, so the endpoint structure is 
`api/<version>[v1, v2]/<endpoint>`

for example, `api/v1/customers`

### Get All Customers

`GET /api/v1/customers`

Retrives a list of all available customers. 
`Status - 200`

**Parameters**

|Parameter|Type                     |Allowed Operators|Allowed Values|Description                                                |
|:----------|:------------------|:------------------|:---------------|:--------------------------------------------|
|  id           | Optional, integer |  =, nte                 | all                   | Filter customers by id                                 |
|  name     | Optional, string   |  =, nte                 | all                   | Filter customers by name                           |
|  type       | Optional, string   |  =, nte                 | I, B, i, b           | Filter customers by type                             |
|  email     | Optional, string   |  =, nte                 | email               | Filter customers by email                           |
|  address | Optional, string   |  =, nte                 | all                   | Filter customers by address                        |
|  city        | Optional, string   |  =, nte                 | all                   | Filter customers by city                               |
|  state      | Optional, string   |  =, nte                 | all                   | Filter customers by state                             |
|  postalCode     | Optional, string \| integer   |  =, nte, gt, lt, gte, lte                 | all                   | Filter customers by postalCode                           |
|  includeInvoices   |  boolean    |  =    |  true    |  Retrives all associated Invoices along with each customer   |

**Example Request:**
```shell
curl -X GET "https://example.com/api/customers?type=I&city[nte]=Kolkata&postalCode[gt]=123243" \
     -H "Authorization: Bearer YOUR_API_KEY"
```
### Get Specific Customer

`GET /api/v1/customers/<id>`

Retrives a list of all available customers. 
`Status - 200`

**Parameters**
No Parameter allowed.

**Example Request:**
```shell
curl -X GET "https://example.com/api/customers/23" \
     -H "Authorization: Bearer YOUR_API_KEY"
```
### Store Customer Record

`POST /api/v1/customers/`

Creates a customer record. `Status - 201`

**Parameters**

|Parameter|Type                     |Allowed Values|
|:----------|:------------------|:---------------|
|  name     | Required, string   |all                    |
|  type       | Required, string   |I, B, i, b            |
|  email     | Required, string   |email, unique   |
|  address | Required, string   | all                    |
|  city        | Required, string   |all                     |
|  state      | Required, string   | all                    |
|  postalCode | Required, string \| integer   | all                   |

**Request Body**
```json
{
  "name": "Jhon doe",
  "type": "I",
    ... ,
  "postalCode": 123444
}
```
**Example Request:**
```shell
curl -X POST "https://example.com/api/customers" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{"name": "Jhon Doe", "type": "I", ... ,"postalCode": 123444}'
```
**Example Reponse ( 201 )**
```json
{
  "id" : 12,
  "name": "Jhon doe",
  "type": "I",
    ... ,
  "postalCode": 123444
}

```
### Update Customer Record

`PUT /api/v1/customers/<id>`

Updates whlole customer record. `Status - 200`

**Parameters**

Same as POST.

**Request Body**
```json
{
  "name": "Jhon doe",
  "type": "I",
    ... ,
  "postalCode": 123444
}
```
**Example Request:**
```shell
curl -X PUT "https://example.com/api/customers" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{"name": "Jhon Doe", "type": "I", ... ,"postalCode": 123444}'
```
**Example Reponse ( 200 )**
```json
{ }
```
`PATCH /api/v1/customers/<id>`

Updates a specific details of a customer. `Status - 200`

**Parameters**

Same as POST, but all parameters are not mandatory

**Request Body**
```json
{
  "name": "Jhon doe",
  "type": "I",
}
```
**Example Request:**
```shell
curl -X PUT "https://example.com/api/customers" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{"name": "Jhon Doe", "type": "I"}'
```
**Example Reponse ( 200 )**
```json
{ }
```
### Delete Specific Customer

`DELETE /api/v1/customers/<id>`

Deletes a customer record. 
`Status - 204`

**Parameters**
No Parameter allowed.

**Example Request:**
```shell
curl -X DELETE "https://example.com/api/customers/23" \
     -H "Authorization: Bearer YOUR_API_KEY"
```
**Example Reponse ( 204 )**
```json
{ }
```

### Get All Invoices

`GET /api/v1/invoices`

Retrives a list of all available customers. 
`Status - 200`

**Parameters**

|Parameter      |Type                            |Allowed Operators       |Allowed Values|Description                                                              |
|:--------------|:-----------------------|:-----------------------|:---------------|:----------------------------------------------------|
|  id                 | Optional, integer         |  =, nte                       | all                   | Filter invoices by id                                                   |
|  customerId  | Optional, integer         |  =, nte                       | all                   | Filter invoices by customer id                                   |
|  amount        | Optional, integer         |  =, nte, gt, lt, gte, lte  | all                  | Filter invoices by amount                                          |
|  status           | Optional, string           |  =, nte                       | V, P, B, v, p, b | Filter invoices by status, V: Void, B: Billed, P : Paid  |
|  billedDate    | Optional, date-string   |  =, nte, gt, lt, gte, lte | Y- m - d H : i : s                   | Filter invoices by billed date                                     |
|  paidDate      | Optional, date-string   |  =, nte, gt, lt, gte, lte | Y- m - d H : i : s                      | Filter invoices by paid date                                      |

**Example Request:**
```shell
curl -X GET "https://example.com/api/invoices?status=P&amount[gte]=2500" \
     -H "Authorization: Bearer YOUR_API_KEY"
```

### Get Specific Invoice

`GET /api/v1/invoices/<id>`

Retrives a list of all available customers. 
`Status - 200`

**Parameters**
No Parameter allowed.

**Example Request:**
```shell
curl -X GET "https://example.com/api/invoices/23" \
     -H "Authorization: Bearer YOUR_API_KEY"
```
### Store Customer Record

`POST /api/v1/invoices/`

Creates a invoice record. `Status - 201`

**Parameters**

|Parameter|Type                     |Allowed Values|
|:----------|:------------------|:---------------|
|  customerId     | Required, integer   |all                    |
|  amount       | Required, integer   | all            |
|  status     | Required, string   | P, V, B, p, v, b  |
|  billedDate | Required, string   | date                    |
|  paidDate        | string   |date                     |

**Request Body**
```json
{
  "customerId": 1,
  "amount": 2500,
  "status": "p",
  "billedDate" : "2025-12-8 16:23:00"
}
```
**Example Request:**
```shell
curl -X POST "https://example.com/api/customers" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{"customerId": 1, "amount": 2500, ... ,"billedDate": "2025-12-8 16:23:00"}'
```
**Example Reponse ( 201 )**
```json
{
  "id" : 12,
  "customerId": 1,
  "amount": 2500,
  "status": "p",
  "billedDate" : "2025-12-8 16:23:00",
  "paidDate": null
}

```
### Update Invoice Record

`PUT /api/v1/customers/<id>`

Updates whole invoice record. `Status - 200`

**Parameters**

Same as POST.

**Request Body**
```json
{
  "customerId": 1,
  "amount": 2500,
  "status": "p",
  "billedDate" : "2025-12-8 16:23:00"
}
```
**Example Request:**
```shell
curl -X PUT "https://example.com/api/customers" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{"customerId": 1, "amount": 2500, ... ,"billedDate": "2025-12-8 16:23:00"}'
```
**Example Reponse ( 200 )**
```json
{ }
```
`PATCH /api/v1/customers/<id>`

Updates a specific details of a invoice. `Status - 200`

**Parameters**

Same as POST, but all parameters are not mandatory

**Request Body**
```json
{
  "status": "V",
}
```
**Example Request:**
```shell
curl -X PUT "https://example.com/api/customers" \
     -H "Authorization: Bearer YOUR_API_KEY" \
     -H "Content-Type: application/json" \
     -d '{"status" : "V"}'
```
**Example Reponse ( 200 )**
```json
{ }
``````
### Delete Specific Customer

`DELETE /api/v1/invoices/<id>`

Deletes the Invoice Record.
`Status - 204`

**Parameters**
No Parameter allowed.

**Example Request:**
```shell
curl -X DELETE "https://example.com/api/invoices/23" \
     -H "Authorization: Bearer YOUR_API_KEY"
```
**Example Reponse ( 204 )**
```json
{ }
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
