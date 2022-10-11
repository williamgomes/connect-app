# Notes

---

- [Create](#create)

### Model

Parameter | Type | Description
--------- | ---- | -----------
client_id | integer | The ID of the client the note belongs to. 
user_id | integer | The ID of the author of the note 
note | text | The actual note. 

<a name="create"></a>
## Create

This endpoint creates a note to the client in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/clients/{client_id}/notes`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The ID of the client the note is belongs to.  
note| string | **Yes** | The text of the note.  

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/clients/{client_id}/notes \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
          "note": "Did not pay last month",
        }'
```

### Example Response

```json
{
  "data": {
    "id": 2164,
    "note": "Did not pay last month",
    "user": null,
    "client": {
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
}
```