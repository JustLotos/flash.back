import Card from "../../pages/Card";
import CardDetail from "../../pages/Card/CardDetail";

export default [{
        path: '/card/:id',
        label: 'Учить',
        component: Card,
        meta: { requiresAuth: true },
        children: [
            { path:'', name:'card', label: 'Карта', component: CardDetail, props: true },
        ]
}]