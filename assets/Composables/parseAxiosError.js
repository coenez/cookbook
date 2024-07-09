
export function parseAxiosError(errorObject) {
    return  {
        message: errorObject.message,
        code: errorObject.code,
        status: errorObject.response.status
    };

}