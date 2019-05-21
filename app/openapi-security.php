<?php
/**
 * @OA\SecurityScheme(
 *   type="apiKey",
 *   securityScheme="jwt_auth",
 *   in="header",
 *   name="Authorization",
 *   description="To make authenticated requests via http using the built in methods, you will need to set an authorization header as follows:\n```\nAuthorization: Bearer {yourtokenhere}\n```\n",
 * )
 */
