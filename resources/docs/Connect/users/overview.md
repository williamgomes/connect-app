# Users

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the user object.
synega_id | integer | The synega ID of the user.
onelogin_id | integer | The onelogin ID of the user.
duo_id | string | The duo ID of the user.
first_name | string | The first name of the user.
last_name | string | The last name of the user.
username | string | The username of the user.
email | string | The email address of the user.
phone_number | integer | The phone number of the user.
role | integer | The role of the user.
slack_webhook_url | integer | The slack webhook URL of the user.
active | boolean | Determines if the user is active or deactivated.
blog_notifications | boolean | Determines if the whether to send blog notifications to the user or not.
created_at | datetime | The date of the user creation.
updated_at | datetime | The date of the user last update.

<a name="index"></a>
## Index

This endpoint indexes all users in Connect.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/users`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page | integer | No | Which page of the paginated response we should return.
synega_id | integer | No | Search for a specific synega ID.
first_name | string | No | Search for a specific first name.
last_name | string | No | Search for a specific last name.
username | string | No | Search for a specific username.
email | string | No | Search for a specific email.
phone_number | integer | No | Search for a specific phone number.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/users?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "synega_id": 323,
      "onelogin_id": null,
      "duo_id": null,
      "active": true,
      "first_name": "John",
      "last_name": "Doe",
      "username": "johndoe",
      "email": "john.doe@synega.com",
      "phone_number": 4712341234,
      "role": 10,
      "slack_webhook_url": null,
      "blog_notifications": true
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v1/users?page=1",
    "last": "https://{environment}.synega.com/api/v1/users?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v1/users",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a user in Connect.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/users`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
synega_id | integer | **Yes** | The synega ID of the user.
onelogin_id | integer | No | The onelogin ID of the user.
duo_id | string | No | The duo ID of the user.
first_name | string | **Yes** | The first name of the user.
last_name | string | **Yes** | The last name of the user.
username | string | No | The username of the user.
email | string | **Yes** | The email address of the user.
phone_number | string | **Yes** | The phone number of the user.
role | integer | No | The role of the user.
slack_webhook_url | string | No | The slack webhook URL of the user.
active | boolean | No | Determines if the user is active or deactivated.
blog_notifications | boolean | No | Determines if the whether to send blog notifications to the user or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/users \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "first_name": "John",
        "last_name": "Doe",
        "email": "john_doe@example.com",
        "phone_number" : "+47833333145",
        "synega_id": 190
    }'
```

### Example Response

```json
{
  "data": {
    "id": 6,
    "synega_id": 327,
    "onelogin_id": null,
    "duo_id": null,
    "active": true,
    "first_name": "John",
    "last_name": "Doe",
    "username": "john.doe",
    "email": "john_doe@example.com",
    "phone_number": 47833333145,
    "role": 30,
    "slack_webhook_url": null,
    "blog_notifications": true
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific user in Connect.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id <small>(url param)</small> | integer | **Yes** | The unique ID of the user.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/users/{user_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 6,
    "synega_id": 327,
    "onelogin_id": null,
    "duo_id": null,
    "active": true,
    "first_name": "John",
    "last_name": "Doe",
    "username": "john.doe",
    "email": "john_doe@example.com",
    "phone_number": 47833333145,
    "role": 30,
    "slack_webhook_url": null,
    "blog_notifications": true
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific user in Connect.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v1/users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id <small>(url param)</small> | integer | **Yes** | The ID of the user to be updated.
synega_id | integer | No | The synega ID of the user.
onelogin_id | integer | No | The onelogin ID of the user.
duo_id | string | No | The duo ID of the user.
first_name | string | No | The first name of the user.
last_name | string | No | The last name of the user.
username | string | No | The username of the user.
email | string | No | The email address of the user.
phone_number | string | No | The phone number of the user.
role | integer | No | The role of the user.
slack_webhook_url | string | No | The slack webhook URL of the user.
active | boolean | No | Determines if the user is active or deactivated.
blog_notifications | boolean | No | Determines if the whether to send blog notifications to the user or not.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v1/users/{user_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "active": false
    }'
```

### Example Response

```json
{
  "data": {
    "id": 6,
    "synega_id": 327,
    "onelogin_id": null,
    "duo_id": null,
    "active": false,
    "first_name": "John",
    "last_name": "Doe",
    "username": "john.doe",
    "email": "john_doe@example.com",
    "phone_number": 47833333145,
    "role": 30,
    "slack_webhook_url": null,
    "blog_notifications": true
  }
}
```
