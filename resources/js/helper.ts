export function formatDate(value: string|null) {
    if(!value) return '';
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(
        new Date(value)
    )
}