import * as React from "react";
import { Navbar } from './components/Navbar';
import { Box, MuiThemeProvider, CssBaseline } from "@material-ui/core";
import { BrowserRouter } from "react-router-dom";
import AppRouter from "./routes/AppRouter";
import Breadcrumb from "./components/Breadcrumb";
import theme from "./theme";

function App() {
    return (
        <React.Fragment>
            <MuiThemeProvider theme={theme}>
                <CssBaseline/>
                <BrowserRouter> {/* tipo de roteamento */}
                    <Navbar />
                    <Box paddingTop={'90px'}>
                        <Breadcrumb/>
                        <AppRouter/>
                    </Box>
                </BrowserRouter>
            </MuiThemeProvider>
        </React.Fragment>
    )
}

export default App;
