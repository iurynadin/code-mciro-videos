// import * as yup from 'yup';
const yup = require('yup');

const schema = yup.object().shape({
    name: yup
        .string()
        .required(),
    num: yup.number()
});

schema
    .isValid({name: 'test', num: '2'})
    .then(isValid => console.log(isValid));

schema.validate({name: 'test', num: 'aaaa'})
    .then((values) => console.log(values))
    .catch(errors => console.log('errors', errors));
