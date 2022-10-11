# Users

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)
- [Search](#search)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the user object.
name | string | The full name of the user.
email | string | The email address / username of the user.
country | string | The country of the user.
salary | integer | The salary of the user.
experience | integer | The experience of the user.
degree | string | The degree of the user.
work_title | string | The work title of the user.
level | integer | The level of the user.
synega_id | integer | The synega ID of the user.
external_id | string | The external ID of the user.
client_id | integer | The ID or internal project of the user..
manager_id | integer | The default manager ID of the user.
phone | integer | The phone number of the user.
role | integer | The role of the user.
active | boolean | Determines if the user is active or deactivated.
out_of_office | boolean | Determines if the user is out of office.
authorized | boolean | Determines if the user is authorized.
yearly_statement_capacity | integer | The yearly statement capacity of the user.
new_clients | boolean | Determines if the user is available for new users.
updated_profile | boolean | Determines if the user has updated profile.
about | text | The description about the user.
level_increased_at | datetime | The date when the level of the user last increased.
format_phone_number | string | The phone number of the user with + prefix.
profile_picture_url | string | The temporary full url of the user profile picture.
accept_incoming_calls | string | Determines if the user accepts incoming calls or not.
seen_at | datetime | The date when the user was seen last time.
created_at | datetime | The date of the user creation.
updated_at | datetime | The date of the user last update.

<a name="index"></a>
## Index

This endpoint indexes all users in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/users`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
synega_id <small>(url param)</small> | integer | No | Search for a specific synega_id.
manager_id <small>(url param)</small> | integer | No | Search for a specific manager_id.
name <small>(url param)</small> | string | No | Search for a specific name.
email <small>(url param)</small> | string | No | Search for a specific email.
phone <small>(url param)</small> | integer | No | Search for a specific phone

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/users?page=1 \
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
      "synega_id": 100,
      "manager_id": 1,
      "external_id": null,
      "role": 10,
      "active": true,
      "level": 6,
      "name": "John Doe",
      "work_title": "Administrator",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "out_of_office": false,
      "about": "",
      "profile_picture_url": "profile-picture-url"
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/users?page=1",
    "last": "https://{environment}.synega.com/api/v3/users?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/users",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a user in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/users`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | **Yes** | The full name of the user.
email | string | **Yes** | The email address / username of the user.
synega_id | integer | **Yes** | The synega ID of the user.
external_id | string | **Yes** | The external ID of the user.
role | integer | **Yes** | The role of the user.
active | bool | No | Determines if the user is active or deactivated.
manager_id | integer | No | The default manager ID of the user.
phone | integer | No | The phone number of the user.
work_title | string | No | The work title of the user.
level | integer | No | The level of the user.
about | string | No | About the user.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/users \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "John Doe",
        "email": "john.doe@synega.com",
        "synega_id": 100,
        "manager_id": 1,
        "role": 10,
    }'
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "synega_id": 100,
        "manager_id": 1,
        "external_id": null,
        "role": 10,
        "active": true,
        "level": 6,
        "name": "John Doe",
        "work_title": "Administrator",
        "email": "john.doe@synega.com",
        "phone": 4712341234,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "profile-picture-url"
    }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific user in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id <small>(url param)</small> | integer | **Yes** | The unique ID of the user.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/users/{user_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
        "id": 1,
        "synega_id": 100,
        "manager_id": 1,
        "external_id": null,
        "role": 10,
        "active": true,
        "level": 6,
        "name": "John Doe",
        "work_title": "Administrator",
        "email": "john.doe@synega.com",
        "phone": 4712341234,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "profile-picture-url"
    }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific user in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/users/{user_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | No | The full name of the user.
email | string | No | The email address / username of the user.
synega_id | integer | No | The synega ID of the user.
external_id | string | No | The external ID of the user.
role | integer | No | The role of the user.
active | bool | No | Determines if the user is active or deactivated.
manager_id | integer | No | The default manager ID of the user.
phone | integer | No | The phone number of the user.
work_title | string | No | The work title of the user.
level | integer | No | The level of the user.
about | string | No | About the user.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/users/{user_id} \
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
        "id": 1,
        "synega_id": 100,
        "manager_id": 1,
        "external_id": null,
        "role": 10,
        "active": true,
        "level": 6,
        "name": "John Doe",
        "work_title": "Administrator",
        "email": "john.doe@synega.com",
        "phone": 4712341234,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "profile-picture-url"
    }
}
```

<a name="search"></a>
## Search

This endpoint searches a users in TMS with given parameters.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/users/search`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
active | string | **Yes** | Determines if the user is active or deactivated.
name | string | No | The full name of the user.
email | string | No | The email address / username of the user.
phone | integer | No | The phone number of the user.
work_title | string | No | The work title of the user.
country | string | No | The country of the user.
yearly_statement_capacity | integer | No | The yearly statement capacity of the user.
role | integer | No | The role of the user.
authorized | boolean | No | Determines if the user is authorized.
new_clients | boolean | No | Determines if the user is available for new users.
out_of_office | boolean | No | Determines if the user is out of office.
country_types | array | No | An array of country type IDs.
country_types.* | integer | No | The ID of country type
task_types | array | No | An array of task type IDs.
task_types.* | integer | No | The ID of task type
systems | array | No | An array of system IDs.
systems.* | integer | No | The ID of system type.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/users/search \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "active": true,
        "role": 10   
    }'
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "synega_id": 100,
      "manager_id": 1,
      "external_id": null,
      "role": 10,
      "active": true,
      "level": 6,
      "name": "John Doe",
      "work_title": "Administrator",
      "email": "john.doe@synega.com",
      "phone": 4712341234,
      "out_of_office": false,
      "about": "",
      "profile_picture_url": "profile-picture-url"
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/users?page=1",
    "last": "https://{environment}.synega.com/api/v3/users?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/users",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```
