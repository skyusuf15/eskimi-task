<?php

namespace App\Common;

class ResponseMessages
{
    public const METHOD_NOT_IMPLEMENTED = 'This method is not implemented.';
    public const INVALID_PARAMS = 'Invalid parameters supplied.';
    public const INVALID_LOGIN_DETAILS = 'Invalid login details supplied.';
    public const UNAUTHORIZED = 'You\'re not allowed to access this resource.';
    public const USERS_NOT_FOUND = 'No users were found.';
    public const INVALID_USER = 'User not found.';
    public const INVALID_ADVERT = 'Advertisement not found.';
    public const USER_UPDATE_ERROR = 'Error occurred whilst updating user. Please try again.';
    public const USER_CREATION_ERROR = 'Failed to create user. Please try again later.';
    public const ERROR_PROCESSING_REQUEST = 'There was a system error while processing request.';
    public const DEPRECATED_ENDPOINT = 'This endpoint has been deprecated.';
    public const AUTH_NOT_PERMITTED_ON_APP = 'You do not have access to the requested application.';
    public const AUTH_INCOMPLETE_SETUP = 'Your account setup is incomplete. Kindly contact customer support team.';
}
