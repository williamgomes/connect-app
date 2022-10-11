# Contact Emails

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)
- [Delete](#delete)

All Contact Email's are assigned to one contact. Each contact can only have 1 primary email address, if an email is created and no other exists, then the email will automaticlly become primary for the given contact.

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the contact email object.
primary | boolean | If the email object is the primary one to the contact.
no_reply | boolean | If the email is a no-reply email address.
address | string | The actual email address for the email object.

<a name="index"></a>
## Index

This endpoint indexes all contact emails in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/contacts{contact_id}/emails`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact where the email should be created.
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 5429,
      "primary": true,
      "no_reply": false,
      "address": "test@synega.com"
    },
    {
      "id": 5430,
      "primary": false,
      "no_reply": false,
      "address": "test2@synega.com"
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/contacts/6322/emails?page=1",
    "last": "https://{environment}.synega.com/api/v3/contacts/6322/emails?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/contacts/6322/emails",
    "per_page": 10,
    "to": 2,
    "total": 2
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a contact email in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact where the email should be created.
address | string | **Yes** | The email address of the contact email.
primary | boolean | No | Determines if the email should be primary or not.
no_reply | boolean | No | Determines if the email is a no-reply address or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "address": "test3@synega.com",
        "primary": false
    }'
```

### Example Response

```json
{
  "data": {
    "id": 5432,
    "primary": false,
    "no_reply": false,
    "address": "test3@synega.com"
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific contact email in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails/{contact_email_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
contact_email_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact email.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails/{contact_email_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 5432,
    "primary": false,
    "no_reply": false,
    "address": "test3@synega.com"
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific contact email in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails/{contact_email_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
contact_email_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact email.
name | string | No | The name of the contact.
active | boolean | No | Determines if the contact is active or not.
notes | string | No | The notes of the contact.
for_all_clients | boolean | No | Determines if the contact is for all clients or not.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails/{contact_email_id} \
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
    "id": 5432,
    "primary": true,
    "no_reply": false,
    "address": "test3@synega.com"
  }
}
```

<a name="delete"></a>
## Delete

This endpoint deletes a specific contact email in TMS.

> {warning} You will not be able to delete a contact email that we've sent or recived more than 1 email from.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails/{contact_email_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.
contact_email_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact email.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/contacts/{contact_id}/emails/{contact_email_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```
