import * as React from 'react';
import { Box, Button, Checkbox, TextField, makeStyles, Theme } from "@material-ui/core";
import { ButtonProps } from "@material-ui/core/Button";
import { useForm } from "react-hook-form";
import categoryHttp from '../../util/http/category-http';
import * as yup from 'yup';

const useStyles = makeStyles((theme: Theme) => {
    return {
        submit: {
            margin: theme.spacing(1)
        }
    }
});

const validationSchema = yup.object().shape({
    name: yup.string()
        .required()
});

export const Form = () => {

    const classes = useStyles();

    const buttonProps: ButtonProps = {
        className: classes.submit,
        color: 'secondary',
        variant: 'contained'
    };

    const {register, handleSubmit, getValues, errors} = useForm({
        validationSchema,
        defaultValues: {
            is_active: true
        }
    });

    function onSubmit(formData, event) {
        // console.log(event);
        categoryHttp
            .create(formData)
            .then((response) => console.log(response));
    }

    console.log(errors);

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <TextField
                name="name"
                label="Nome"
                fullWidth
                variant={"outlined"}
                inputRef={register({
                    required: 'O campo nome é requerido!',
                    maxLength: {
                        value: 2,
                        message: 'O mAximo de caracteres é 2'
                    }
                })}
                error={ errors.name !== undefined }
                />
            <TextField
                name="description"
                label="Descrição"
                multiline
                rows="4"
                fullWidth
                variant={"outlined"}
                margin={"normal"}
                inputRef={register}
            />
            <Checkbox
                name="is_active"
                color={"primary"}
                inputRef={register}
                defaultChecked
            />
            Ativo?
            <Box dir={"rtl"}>
                <Button { ...buttonProps } onClick={() => onSubmit(getValues(), null)}>Salvar</Button> {/* onClick={() => console.log(getValues())} */}
                <Button { ...buttonProps } type="submit">Salvar e continuar editando</Button>
            </Box>
        </form>
    )
}
