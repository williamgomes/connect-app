# Clients

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)
- [Active IDs](#active)

### Model

Parameter | Type | Description
--------- | ---- | -----------
type | string | The type of the client 
client_id | integer | The ID of the actual client if the lead was won 
manager_id | integer | The unique ID of the manager of the client 
employee_id | integer | The unique ID of the employee (consultant) of the client 
demo_id | integer | The demo template ID the client was created from. 
name | string | The name of the client 
organization_number | string (digits:9) | The organization number of the client 
fiken_id | integer | The fiken ID of the client 
system_id | integer | The system ID of the client 
customer_type | integer | The customer type of the client 
country_code | string (max:2) | The country code of the client 
city | string | The city of the client. 
address | string | The address of the client 
postal_code | integer | The postal code of the client 
invoice_contact_email_id | integer | The default contact email ID to be used in invoices 
contact_email_id | integer | The default contact email ID 
contact_phone_id | integer | The default contact phone ID 
note | text | The note about the clients 
paid | boolean | Determines if the client is paid or not 
active | boolean | Determines if the client is active or not 
paused | boolean | Determines if the client is paused or not 
risk | boolean | Determines if there is a risk with the client 
risk_reason | string | The actual risk reason description 
complaint_case | boolean | Determines if there is complaint case with the client 
show_folders | boolean | Determines to hide or show file folders on client show page 
newsletter | boolean | Determines if subscribed to newsletters or not 
created_at | datetime | The date of the client creation 
updated_at | datetime | The date of the client last update

<a name="index"></a>
## Index

This endpoint indexes all clients in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
organization_number <small>(url param)</small> | string | No | Search for a specific organization number. Can be either string or integer. We only return excact match.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": [
        {
            "id": 3678,
            "name": "Test Client",
            "type": "client",
            "organization_number": null,
            "system": {
              "id": 1,
              "name": "Fiken",
              "visible": true,
              "default": false
            },
            "customer_type": {
              "id": 3,
              "name": "Privatperson"
            },
            "manager": {
              "id": 1,
              "active": true,
              "name": "John Doe",
              "email": "john.doe@synega.com",
              "phone": 4712341234,
              "about": "",
              "profile_picture_url": "profile-url-here"
            },
            "employee": {
              "id": 1,
              "active": true,
              "name": "John Doe",
              "email": "john.doe@synega.com",
              "phone": 4712341234,
              "about": "",
              "profile_picture_url": "profile-url-here"
            },
            "invoice_contact_email": null,
            "contact_email": null,
            "contact_phone": null,
            "paid": true,
            "active": true,
            "paused": false,
            "newsletter": true
          },
          ...
    ],
    "links": {
        "first": "https://{environment}.synega.com/api/v3/clients?page=1",
        "last": "https://{environment}.synega.com/api/v3/clients?page=97",
        "prev": null,
        "next": "https://{environment}.synega.com/api/v3/clients?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 97,
        "links": [
            {
                "url": "https://{environment}.synega.com/api/v3/clients?page=1",
                "label": 1,
                "active": true
            }
        ],
        "path": "https://{environment}.synega.com/api/v3/clients",
        "per_page": 10,
        "to": 10,
        "total": 2418
    }
}
```

<a name="create"></a>
## Create

This endpoint creates a client in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/clients`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | **Yes** | The name of the client 
system_id | integer | **Yes** | The system ID of the client 
manager_id | integer | **Yes** | The unique ID of the manager of the client 
employee_id | integer | **Yes** | The unique ID of the employee (consultant) of the client 
contact_type | string | **Yes** | The type of contact (*existing/new*) which is supposed to be assigned to a client
contact_id | integer | **Yes** (if *contact_type* is *existing*) | The ID of creating client's existing contact  
contact_name | string | **Yes** (if *contact_type* is *new*) | The name of creating client's contact  
contact_email | string | **Yes** (if *contact_type* is *new*) | The email of creating client's contact  
contact_phone | string | **Yes** (if *contact_type* is *new*) | The phone of creating client's contact  
type | string  | No | The type of the client 
organization_number | integer | No | The organization number of the client 
customer_type | integer | No | The customer type of the client 
paid | boolean | No | Determines if the client is paid or not 
active | boolean | No | Determines if the client is active or not 
paused | boolean | No | Determines if the client is paused or not 
show_folders | boolean | No | Determines to hide or show file folders on client show page 
risk | boolean | No | Determines if there is a risk with the client 
risk_reason | string | No | The actual risk reason description 
complaint_case | boolean | No | Determines if there is complaint case with the client 

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/clients \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "New Client",
        "system_id": 1,
        "manager_id": 1,
        "employee_id": 1,
        "contact_type": "existing",
        "contact_id": 3220
    }'
```

### Example Response

```json
{
  "data": {
    "id": 3678,
    "name": "Test Client",
    "type": "client",
    "organization_number": null,
    "system": {
      "id": 1,
      "name": "Fiken",
      "visible": true,
      "default": false
    },
    "customer_type": {
      "id": 3,
      "name": "Privatperson"
    },
    "manager": {
      "id": 1,
      "active": true,
      "name": "John Doe",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "about": "",
      "profile_picture_url": "profile-url-here"
    },
    "employee": {
      "id": 1,
      "active": true,
      "name": "John Doe",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "about": "",
      "profile_picture_url": "profile-url-here"
    },
    "invoice_contact_email": null,
    "contact_email": null,
    "contact_phone": null,
    "paid": true,
    "active": true,
    "paused": false,
    "newsletter": true
  }
}
```
> {info} Manager and Employee will be assigned after admin confirmation.

<a name="show"></a>
## Show

This endpoint shows a specific client in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/{client_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 3678,
    "name": "Test Client",
    "type": "client",
    "organization_number": null,
    "system": {
      "id": 1,
      "name": "Fiken",
      "visible": true,
      "default": false
    },
    "customer_type": {
      "id": 3,
      "name": "Privatperson"
    },
    "manager": {
      "id": 1,
      "active": true,
      "name": "John Doe",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "about": "",
      "profile_picture_url": "profile-url-here"
    },
    "employee": {
      "id": 1,
      "active": true,
      "name": "John Doe",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "about": "",
      "profile_picture_url": "profile-url-here"
    },
    "invoice_contact_email": null,
    "contact_email": null,
    "contact_phone": null,
    "paid": true,
    "active": true,
    "paused": false,
    "newsletter": true
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific client in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/clients/{client_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
type | string | No | The type of the client 
client_id | integer | No | The ID of the actual client if the lead was won 
manager_id | integer | No | The unique ID of the manager of the client 
employee_id | integer | No | The unique ID of the employee (consultant) of the client 
demo_id | integer | No | The demo template ID the client was created from. 
name | string | No | The name of the client 
organization_number | string | No | The organization number of the client 
fiken_id | integer | No | The fiken ID of the client 
system_id | integer | No | The system ID of the client 
customer_type | integer | No | The customer type of the client 
country_code | string | No | The country code of the client 
city | string | No | The city of the client. 
address | string | No | The address of the client 
postal_code | integer | No | The postal code of the client 
invoice_contact_email_id | integer | No | The default contact email ID to be used in invoices 
contact_email_id | integer | No | The default contact email ID 
contact_phone_id | integer | No | The default contact phone ID 
note | text | No | The note about the clients 
paid | boolean | No | Determines if the client is paid or not 
active | boolean | No | Determines if the client is active or not 
paused | boolean | No | Determines if the client is paused or not 
risk | boolean | No | Determines if there is a risk with the client 
risk_reason | string | No | The actual risk reason description 
complaint_case | boolean | No | Determines if there is complaint case with the client 
show_folders | boolean | No | Determines to hide or show file folders on client show page 
newsletter | boolean | No | Determines if subscribed to newsletters or not 

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/clients/{client_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "New Test Name",
        "active": false
    }'
```

### Example Response

```json
{
  "data": {
    "id": 3678,
    "name": "New Test Name",
    "type": "client",
    "organization_number": null,
    "system": {
      "id": 1,
      "name": "Fiken",
      "visible": true,
      "default": false
    },
    "customer_type": {
      "id": 3,
      "name": "Privatperson"
    },
    "manager": {
      "id": 1,
      "active": true,
      "name": "John Doe",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "about": "",
      "profile_picture_url": "profile-url-here"
    },
    "employee": {
      "id": 1,
      "active": true,
      "name": "John Doe",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "about": "",
      "profile_picture_url": "profile-url-here"
    },
    "invoice_contact_email": null,
    "contact_email": null,
    "contact_phone": null,
    "paid": true,
    "active": false,
    "paused": false,
    "newsletter": true
  }
}
```
<a name="active"></a>
## Active IDs

This endpoint indexes all active clients' IDs in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/active`

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/active \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    3,
    5,
    10,
    17,
    19,
    23
  ]
}
```