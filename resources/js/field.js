Nova.booting((Vue, router, store) => {
    Vue.component('index-nova-file-upload-field', require('./components/IndexField'))
    Vue.component('detail-nova-file-upload-field', require('./components/DetailField'))
    Vue.component('form-nova-file-upload-field', require('./components/FormField'))
})
