# Custom Fields

---

- [Update](#update)

### Model

Parameter | Type | Description
--------- | ---- | -----------
custom_fields | array | The array of custom fields with values which are supposed to be filled/updated. 

<a name="update"></a>
## Update

This endpoint fills/updates custom fields of the client.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/clients/{client_id}/custom-fields`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.
custom_fields | array | **Yes** | The array of custom fields with values.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/clients/{client_id}/custom-fields \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "custom_fields": [
          "owner_id": 204,
          "personal_sale": 10,
          "main_address": "",
        ]
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
    "newsletter": true,
    "custom_fields": {
      "owner_id": 204,
      "personal_sale": 10,
      "main_address": null,
      "priority": null
    }
  }
}
```


