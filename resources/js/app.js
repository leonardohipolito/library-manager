import './bootstrap';
document.addEventListener('alpine:init', () => {
    Alpine.magic('deleteModal', () => (route,redirectUrl) => {
        confirm('Confirm exclusion?') && axios.delete(route).then(() => redirectUrl?window.location=redirectUrl:window.location.reload());
    })
})
