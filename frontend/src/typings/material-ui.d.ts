import { ComponentNameToClassKey } from '@material-ui/core/styles/overrides';
import { PaletteOptions, PaletteColorOptions, Palette, PaletteColor } from "@material-ui/core/styles/createPalette";

declare module '@material-ui/core/styles/overrides'{
    interface ComponentNameToClassKey {
        MUIDataTable: any;
        MUIDataTableToolbar: any;
        MUIDataTableHeadCell: any;
        MUITableSortLabel: any;
        MUIDataTableSelectCell: any;
        MUIDataTableBodyCell: any;
        MUIDataTableToolbarSelect: any;
        MUIDataTableBodyRow: any;
        MUIDataTablePagination: any;
    }
}

declare module '@material-ui/core/styles/createPalette'{

    import { PaletteColorOptions } from "@material-ui/core/styles";

    interface Palette {
        success: PalleteColor
    }

    interface PaletteOptions {
        success?: PalleteColorOptions
    }
}
