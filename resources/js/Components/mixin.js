export const error = (message) => {
    ElNotification({
        title: 'Error',
        message: message,
        type: 'error',
    })
}
