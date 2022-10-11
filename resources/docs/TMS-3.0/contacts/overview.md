# Contacts

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)

Contact's are independent and can be linked with multiple client's and lead's. Each contact can have multiple emails and phones linked to them, however only 1 primary of each.

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the contact object.
active | boolean | Determines if the contact is active or not.
for_all_clients | boolean | Determines if the contact is for all clients or not.
name | string | The name of the contact.
notes | string | The notes of the contact.
emails | array | An array of all the linked emails
emails.id | integer | The unique ID for the contact email object.
emails.primary | boolean | If the email object is the primary one to the contact.
emails.no_reply | boolean | If the email is a no-reply email address.
emails.address | string | The actual email address for the email object.
phones | array | An array of all the linked phones
phones.id | integer | The unique ID for the contact phone object.
phones.primary | boolean | If the phone object is the primary one to the contact.
phones.number | string | The actual phone number for the phone object.

<a name="index"></a>
## Index

This endpoint indexes all contacts in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/contacts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
name <small>(url param)</small> | string | No | A contact name
phone_number <small>(url param)</small> | string | No | A valid E.164 phone number to search for.
email_address <small>(url param)</small> | string | No | A valid email address to search for.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts?page=1&phone_number="+4700000000"&email_address="test@synega.com" \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 6314,
      "active": true,
      "for_all_clients": false,
      "name": "Firstname Lastname",
      "notes": "",
      "emails": [
        {
          "id": 5420,
          "primary": true,
          "no_reply": false,
          "address": "test@synega.com"
        },
        {
          "id": 5421,
          "primary": false,
          "no_reply": false,
          "address": "test2@synega.com"
        }
      ],
      "phones": [
        {
          "id": 2859,
          "primary": true,
          "number": "+4700000000"
        }
      ]
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/contacts?page=1",
    "last": "https://{environment}.synega.com/api/v3/contacts?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/contacts",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a contact in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/contacts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | **Yes** | The name of the contact.
active | boolean | No | Determines if the contact is active or not.
notes | string | No | The notes of the contact.
for_all_clients | boolean | No | Determines if the contact is for all clients or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/contacts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "Firstname Lastname",
        "active": true,
        "notes": "A note about the contact here",
        "for_all_clients": false
    }'
```

### Example Response

```json
{
  "data": {
    "id": 6323,
    "active": true,
    "for_all_clients": false,
    "name": "Firstname Lastname",
    "notes": "A note about the contact here",
    "emails": [],
    "phones": []
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific contact in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/contacts/{contact_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts/{contact_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 6314,
    "active": true,
    "for_all_clients": false,
    "name": "Firstname Lastname",
    "notes": "",
    "emails": [
      {
        "id": 5420,
        "primary": true,
        "no_reply": false,
        "address": "test@synega.com"
      },
      {
        "id": 5421,
        "primary": false,
        "no_reply": false,
        "address": "test2@synega.com"
      }
    ],
    "phones": [
      {
        "id": 2859,
        "primary": true,
        "number": "+4700000000"
      }
    ]
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific contact in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/contacts/{contact_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
name | string | No | The name of the contact.
active | boolean | No | Determines if the contact is active or not.
notes | string | No | The notes of the contact.
for_all_clients | boolean | No | Determines if the contact is for all clients or not.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/contacts/{contact_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "New Name",
        "active": false
    }'
```

### Example Response

```json
{
  "data": {
    "id": 6323,
    "active": false,
    "for_all_clients": false,
    "name": "New Name",
    "notes": "A note about the contact here",
    "emails": [
      {
        "id": 5420,
        "primary": true,
        "no_reply": false,
        "address": "test@synega.com"
      },
      {
        "id": 5421,
        "primary": false,
        "no_reply": false,
        "address": "test2@synega.com"
      }
    ],
    "phones": [
      {
        "id": 2859,
        "primary": true,
        "number": "+4700000000"
      }
    ]
  }
}
```

