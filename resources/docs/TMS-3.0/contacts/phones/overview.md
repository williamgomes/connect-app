# Contact Phones

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)
- [Delete](#delete)

All Contact Phone's are assigned to one contact. Each contact can only have 1 primary phone number, if a phone is created and no other exists, then the phone will automaticlly become primary for the given contact.

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the contact phone object.
primary | boolean | If the phone object is the primary one to the contact.
number | string | The actual phone number for the phone object.

<a name="index"></a>
## Index

This endpoint indexes all contact phones in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/contacts{contact_id}/phones`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact where the phone should be created.
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 2869,
      "primary": true,
      "number": "+4700000002"
    },
    {
      "id": 2868,
      "primary": false,
      "number": "+4700000001"
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/contacts/6322/phones?page=1",
    "last": "https://{environment}.synega.com/api/v3/contacts/6322/phones?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/contacts/6322/phones",
    "per_page": 10,
    "to": 2,
    "total": 2
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a contact phone in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact where the phone should be created.
number | string | **Yes** | The phone number of the contact phone. Must be a valid E.164 phone number.
primary | boolean | No | Determines if the phone should be primary or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "number": "+4700000003",
        "primary": false
    }'
```

### Example Response

```json
{
  "data": {
    "id": 2870,
    "primary": false,
    "number": "+4700000003"
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific contact phone in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones/{contact_phone_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
contact_phone_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact phone.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones/{contact_phone_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 2870,
    "primary": false,
    "number": "+4700000003"
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific contact phone in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones/{contact_phone_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
contact_phone_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact phone.
name | string | No | The name of the contact.
active | boolean | No | Determines if the contact is active or not.
notes | string | No | The notes of the contact.
for_all_clients | boolean | No | Determines if the contact is for all clients or not.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones/{contact_phone_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "primary": true
    }'
```

### Example Response

```json
{
  "data": {
    "id": 2870,
    "primary": true,
    "number": "+4700000003"
  }
}
```

<a name="delete"></a>
## Delete

This endpoint deletes a specific contact phone in TMS.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones/{contact_phone_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
contact_phone_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact phone.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/contacts/{contact_id}/phones/{contact_phone_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```
