import React, {useEffect, useState} from 'react';
import { Box, Button, TextField, makeStyles, Theme, FormControl, FormControlLabel, FormLabel, MenuItem } from "@material-ui/core";
import { ButtonProps } from "@material-ui/core/Button";
import { useForm } from "react-hook-form";
import genreHttp from '../../util/http/genre-http';
import categoryHttp from '../../util/http/category-http';

const useStyles = makeStyles((theme: Theme) => {
    return {
        submit: {
            margin: theme.spacing(1)
        }
    }
});

export const Form = () => {

    const classes = useStyles();

    const buttonProps: ButtonProps = {
        className: classes.submit,
        color: 'secondary',
        variant: 'contained'
    };

    const [ categories, setCategories ] = useState<any[]>([])
    const { register, handleSubmit, getValues, setValue, watch } = useForm({
        defaultValues: {
            categories_id: []
        }
    });

    useEffect(() => {
        register({name: "categories_id"})
    }, [register])

    useEffect(() => {
        categoryHttp
            .list()
            .then(response => setCategories(response.data.data));
    }, [])

    function onSubmit(formData, event) {
        // console.log(event);
        genreHttp
            .create(formData)
            .then((response) => console.log(response));
    }

    return (
        <form onSubmit={handleSubmit(onSubmit)}>
            <TextField
                name="name"
                label="Nome"
                fullWidth
                variant={"outlined"}
                inputRef={register}
                />
            <TextField
                select
                name="categories_id"
                value={ watch('categories_id') }
                label="Categorias"
                margin={'normal'}
                variant={"outlined"}
                fullWidth
                onChange={(e: any) => {
                    setValue('categories_id', e.target.value);
                }}
                SelectProps={{
                    multiple: true
                }}
            >
                <MenuItem value="" disabled>
                    <em>Selecione Categorias</em>
                </MenuItem>
                {
                    categories.map((category, key) => (
                        <MenuItem key={key} value={category.id}>{category.name}</MenuItem>
                    ))
                }
            </TextField>

            <Box dir={"rtl"}>
                <Button
                    color={"primary"}
                    { ...buttonProps }
                    onClick={() => onSubmit(getValues(), null)}
                    >Salvar
                </Button> {/* onClick={() => console.log(getValues())} */}
                <Button { ...buttonProps } type="submit">Salvar e continuar editando</Button>
            </Box>
        </form>
    )
}
