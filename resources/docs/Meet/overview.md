# Overview

---

- [General information](#general)
- [Headers](#headers)
- [Rate limiting](#ratelimit)

<a name="general"></a>
## General information

Meet API includes most of the relevant endpoints to do external actions. All our endpoints return valid JSON format's.
<br><br>
You will menu find each entity available in the API in the left side. Within each entity you will find every endpoint that interacts with the given entity.

<a name="headers"></a>
## Headers and authentication

The API requires you to pass the headers specified below.

### Header Parameters

- **Accept** should respect the following schema:
```json
{
    "type": "string",
    "enum": [
        "application/json"
    ],
    "default": "application/json"
}
```

- **Content-Type** should respect the following schema:
```json
{
    "type": "string",
    "enum": [
        "application/json"
    ],
    "default": "application/json"
}
```

- **Authorization** should respect the following schema:
```json
{
    "type": "string",
    "enum": [
        "Bearer { access_token }"
    ],
    "default": "Bearer { access_token }"
}
```

> {primary} The `{ access_token }` is application specific token that the server needs in order to auth the request. Tokens can be generated under any given API Application under System Settings.

<a name="ratelimit"></a>
## Rate limiting

Our API has a rate limit of 120 requests per minute. If you exceed that request limit you will get a `Too Many Attempts` error message. Once the rate limit has cooled down you will be able to make requests as before.
<br><br>
The application can always check the current limit as well as remaining calls via the header value `X-RateLimit-Limit` and `X-RateLimit-Remaining`.
