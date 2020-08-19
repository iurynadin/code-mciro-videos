import React, { useEffect, useState } from "react";
import MUIDataTable, { MUIDataTableColumn } from "mui-datatables";
import { httpVideo } from "../../util/http";
import format from "date-fns/format";
import parseISO from "date-fns/parseISO";

const CastMemberTypeMap = {
    1: 'Diretor',
    2: 'Ator'
};

const columnsDefinition: MUIDataTableColumn[] = [
    {
        name: "name",
        label: "Nome"
    },
    {
        name: "type",
        label: "Tipo",
        options: {
            customBodyRender: (value, tableMeta, updateValue) => {
                return CastMemberTypeMap[value];
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

type Props = {

};

const Table = (props: Props) => {

    const [data, setData] = useState([]);

    useEffect(() => {
        httpVideo.get('cast_members').then(
            response => setData(response.data.data)
        )
    }, []);

    return (
        <div>
            <MUIDataTable
                title="Listagem de membros do elenco"
                columns={columnsDefinition}
                data={data}
            />

        </div>
    );
};

export default Table;
