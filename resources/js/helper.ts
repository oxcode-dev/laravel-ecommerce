export function formatDate(value: string|null) {
    if(!value) return '';
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(
        new Date(value)
    )
}

export function numberFormat(number: number|null) {
    if(!number) return '';

    return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
}