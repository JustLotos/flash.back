import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/Home';
import Login from "./components/Auth/Login";
import Register from "./components/Auth/Register";
import Deck from "./components/Deck/Deck";
import DeckList from "./components/Deck/DeckList";
import Card from "./components/Card/Card";
import CardList from "./components/Card/CardList";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        { path:'/',             name:'home',        component:Home },
        { path:'/login',        name:'login',       component:Login },
        { path:'/register',     name:'register',    component:Register },
        { path:'/deck/:id',     name:'deck',        component:Deck },
        { path:'/deck/list',    name:'deckList',    component:DeckList },
        { path:'/card/:id',     name:'card',        component:Card },
        { path:'/card/list',    name:'cardList',    component:CardList },
    ]
});

export default router;