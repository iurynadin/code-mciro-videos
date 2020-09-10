import React, { useEffect, useState } from "react";
import MUIDataTable, { MUIDataTableColumn } from "mui-datatables";
import { httpVideo } from "../../util/http";
import { Chip } from "@material-ui/core";
import format from "date-fns/format";
import parseISO from "date-fns/parseISO";
import categoryHttp from "../../util/http/category-http";
import { BadgeYes, BadgeNo } from "../../components/Badge";

const columnsDefinition: MUIDataTableColumn[] = [
    {
        name: "name",
        label: "Nome"
    },
    {
        name: "is_active",
        label: "Ativo?",
        options: {
            customBodyRender(value,tableMeta, updateValue){
                return value ? <BadgeYes/> : <BadgeNo/>
            }
        }
    },
    {
        name: "created_at",
        label: "Criado em",
        options: {
            customBodyRender(value,tableMeta, updateValue){
                return <span>{format(parseISO(value), 'dd/mm/yyyy')}</span>;
            }
        }
    }
];

interface Category {
    id: string;
    name: string;
}

type Props = { };

const Table = (props: Props) => {

    const [data, setData] = useState<Category[]>([]);

    useEffect(() => {
        categoryHttp
            .list<{data: Category[]}>()
            .then(({data}) => setData(data.data));
    }, []);

    return (
        <div>
            <MUIDataTable
                title="Listagem de categorias"
                columns={columnsDefinition}
                data={data}
            />

        </div>
    );
};

export default Table;
