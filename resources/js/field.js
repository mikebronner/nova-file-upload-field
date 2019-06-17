Nova.booting((Vue, router, store) => {
    Vue.component('index-nova-file-upload-field', require('./components/IndexField').default)
    Vue.component('detail-nova-file-upload-field', require('./components/DetailField').default)
    Vue.component('form-nova-file-upload-field', require('./components/FormField').default)
})
