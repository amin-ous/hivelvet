/**
 * Hivelvet open source platform - https://riadvice.tn/
 *
 * Copyright (c) 2022 RIADVICE SUARL and by respective authors (see below).
 *
 * This program is free software; you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free Software
 * Foundation; either version 3.0 of the License, or (at your option) any later
 * version.
 *
 * Hivelvet is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with Hivelvet; if not, see <http://www.gnu.org/licenses/>.
 */

import React, { Component } from 'react';
import { Route, Routes } from 'react-router-dom';
import PrivateRoute from './components/PrivateRoute';
import PublicRoute from './components/PublicRoute';

import './App.less';
import { Layout, ConfigProvider, BackTop, Button } from 'antd';
import { CaretUpOutlined } from '@ant-design/icons';

import AppHeader from './components/AppHeader';
import AppFooter from './components/AppFooter';
import AppSider from './components/AppSider';

import Install from './components/Install';
import PageNotFound from './components/PageNotFound';
import LandingPage from './components/LandingPage';
import Register from './components/Register';
import Login from './components/Login';
import Reset from './components/ResetPassword';
import ChangePassword from './components/ChangePassword';

import Home from './components/Home';
import Roles from './components/Roles';

import enUS from 'antd/lib/locale/en_US';
import frFR from 'antd/lib/locale/fr_FR';
import arEG from 'antd/lib/locale/ar_EG';
import moment from 'moment';
import 'moment/locale/fr';
import 'moment/locale/ar';
import 'moment/locale/en-au';
import { tx } from '@transifex/native';

import Logger from './lib/logger';

import authService from './services/auth.service';
import { Props } from 'react-intl/src/components/relative';

moment.locale('en');

const { Content } = Layout;

tx.init({
    token: '1/7385d403dc3545240d6771327397811a619efe18',
});

tx.setCurrentLocale('en');

Logger.info('Initialisation Hivelvet Frontend Application');

type State = {
    currentUser?: any;
    isLogged?: boolean;
    language?: any;
    installed?: any;
};

class App extends Component<Props, State> {
    direction: any = 'ltr';
    // to be changed by backend after installation
    isInstalled: boolean = JSON.parse(process.env.REACT_APP_INSTALLED) || false;

    constructor(props: Props) {
        super(props);
        tx.setCurrentLocale('en');

        this.state = {
            currentUser: null,
            isLogged: false,
            language: enUS,
            installed: this.isInstalled,
        };
    }
    componentDidMount = () => {
        this.setLang(enUS);
        const user = authService.getCurrentUser();
        if (authService.getCurrentUser() != null) this.setUser(user, true);
    };
    setUser = (user, Logged) => {
        this.setState({
            currentUser: user,
            isLogged: Logged,
        });
    };
    setLang = (lang) => {
        this.setState({
            language: lang,
        });
        this.direction = lang.locale !== 'ar' ? 'ltr' : 'rtl';
    };
    setInstall = () => {
        // @todo for future tasks change env var REACT_APP_INSTALLED to true
        this.setState({
            installed: true,
        });
    };

    render() {
        const { currentUser, isLogged, language, installed } = this.state;

        return (
            <Layout>
                <ConfigProvider locale={language} direction={this.direction} componentSize="large">
                    <AppHeader
                        currentUser={currentUser}
                        currentLocale={language}
                        setLang={this.setLang}
                        isLogged={isLogged}
                        setUser={this.setUser}
                        installed={installed}
                    />
                    <Layout>
                        {installed && isLogged && <AppSider />}
                        <Content className="site-content">
                            {installed ? (
                                <Routes>
                                    <Route path="*" element={<PageNotFound />} />
                                    <Route
                                        path="/"
                                        element={
                                            <PublicRoute restricted={true}>
                                                <LandingPage />
                                            </PublicRoute>
                                        }
                                    />
                                    <Route
                                        path="/register"
                                        element={
                                            <PublicRoute restricted={true}>
                                                <Register />
                                            </PublicRoute>
                                        }
                                    />
                                    <Route
                                        path="/login"
                                        element={
                                            <PublicRoute restricted={true}>
                                                <Login setUser={this.setUser} />
                                            </PublicRoute>
                                        }
                                    />
                                    <Route
                                        path="/reset-password"
                                        element={
                                            <PublicRoute restricted={true}>
                                                <Reset />
                                            </PublicRoute>
                                        }
                                    />
                                    <Route
                                        path="/change-password"
                                        element={
                                            <PublicRoute restricted={true}>
                                                <ChangePassword />
                                            </PublicRoute>
                                        }
                                    />

                                    <Route
                                        path="/home"
                                        element={
                                            <PrivateRoute>
                                                <Home isLogged={isLogged} user={currentUser} />
                                            </PrivateRoute>
                                        }
                                    />

                                    <Route path="/settings/roles" element={<PrivateRoute><Roles /></PrivateRoute>}/>

                                </Routes>
                            ) : (
                                <Routes>
                                    <Route
                                        path="/"
                                        element={<Install installed={installed} handleInstall={this.setInstall} />}
                                    />
                                    <Route path="*" element={<PageNotFound />} />
                                </Routes>
                            )}
                        </Content>
                    </Layout>
                    <AppFooter />
                </ConfigProvider>
                <BackTop>
                    <Button type="primary" shape="circle" icon={<CaretUpOutlined />} />
                </BackTop>
            </Layout>
        );
    }
}

export default App;
