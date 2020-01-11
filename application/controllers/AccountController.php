<?php

class AccountController extends Controller
{
    public function signupAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/account');
        }

        return $this->render(array(
            'user_name' => '',
            'password'  => '',
            '_token'    => $this->generatedCsrfToken('account/signup'),
        ));
    }

    public function registerAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/account');
        }

        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('account/signup', $token)) {
            return $this->redirect('account/signup');
        }

        $user_name = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        $errors = array();

        if (!strlen($user_name)) {
            $errors[] = 'ユーザIDを入力してください';
        } else if (!preg_match('/^\w{3,20}$/', $user_name)) {
            $errors[] = 'ユーザIDは半角英数字およびアンダースコアを3~20文字以内で入力してください';
        } elseif (!$this->db_manager->get('User')->isUniqueUserName($user_name)) {
            $errors[] = 'ユーザIDは既に使用されています';
        }

        if (!strlen($password)) {
            $errors[] = 'パスワードを入力してください';
        } elseif (4 > strlen($password) || strlen($password) > 30) {
            $errors[] = 'パスワードは4~30文字以内で入力してください';
        }

        if (count($errors) === 0) {
            $stmt = $this->db_manager->get('User')->insert($user_name, $password);
            $this->session->setAuthenticated(TRUE);

            $user = $this->db_manager->get('User')->fetchByUserName($user_name);
            $this->session->set('user', $user);

            return $this->redirect('/');
        }

        return $this->render(array(
            'user_name' => $user_name,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generatedCsrfToken('account/signup'),
        ), 'signup');
    }

    public function indexAction()
    {
        $user = $this->session->get('User');

        return $this->render(array('user' => $user));
    }

    public function signinAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/account');
        }

        return $this->render(array(
            'user_name' => '',
            'password'  => '',
            '_token'    => $this->generatedCsrfToken('account/signin'),
        ));
    }

    public function authenticateAction()
    {
        if ($this->session->isAuthenticated()) {
            if ($this->session->isAuthenticated()) {
                return $this->redirect('/account');
            }

            if (!$this->request->isPost()) {
                $this->forward404();
            }

            $token = $this->request->getPost('_token');
            if (!$this->checkCsrfToken('account/signin', $token)) {
                return $this->redirect('account/signin');
            }

            $user_name = $this->request->getPost('user_name');
            $password = $this->request->getPost('password');

            $errors = array();

            if (!strlen($user_name)) {
                $errors[] = 'ユーザIDを入力してください';
            }

            if (!strlen($password)) {
                $errors[] = 'パスワードを入力してください';
            }

            if (count($errors) === 0) {
                $user_repository = $this->db_manager->get('User');
                //$user = $user_repository->

            }
        }
    }
}