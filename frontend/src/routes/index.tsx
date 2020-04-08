// exact p evitar colizão de rotas
import { RouteProps } from "react-router-dom";
import Dashboard from "../pages/Dashboard";
import CategoryList from "../pages/category/List";

export interface MyRouteProps extends RouteProps{
    name: string;
    label: string;
}

const routes: MyRouteProps[] = [
    {
        name: 'dashboard',
        label: 'Dashboard',
        path: '/',
        component: Dashboard,
        exact: true,
    },
    {
        name: 'categories.list',
        label: 'Listagem Categorias',
        path: '/categories',
        component: CategoryList,
        exact: true,
    },
];

export default routes;
