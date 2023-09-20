import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-webcam-photo-capture', IndexField)
  app.component('detail-webcam-photo-capture', DetailField)
  app.component('form-webcam-photo-capture', FormField)
})
