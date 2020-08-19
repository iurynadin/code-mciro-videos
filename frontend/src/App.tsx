import * as React from "react";
import { Navbar } from './components/Navbar';
import { Box } from "@material-ui/core";
import { BrowserRouter } from "react-router-dom";
import AppRouter from "./routes/AppRouter";
import Breadcrumb from "./components/Breadcrumb";

function App() {
    return (
        <React.Fragment>
            <BrowserRouter> {/* tipo de roteamento */}
                <Navbar />
                <Box paddingTop={'90px'}>
                    <Breadcrumb/>
                    <AppRouter/>
                </Box>
            </BrowserRouter>
        </React.Fragment>
    )
}

export default App;
