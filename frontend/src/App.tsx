import * as React from "react";
import { Navbar } from './components/Navbar';
import { Box } from "@material-ui/core";
import { BrowserRouter } from "react-router-dom";
import AppRouter from "./routes/AppRouter";

function App() {
    return (
        <React.Fragment>
            <BrowserRouter>
                <Navbar />
                <Box paddingTop={'90px'}>
                    <AppRouter/>
                </Box>
            </BrowserRouter>
        </React.Fragment>
    )
}

export default App;
