export function formatDate(value: string) {
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(
        new Date(value)
    )
}