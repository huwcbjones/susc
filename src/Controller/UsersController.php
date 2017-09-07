<?php

namespace SUSC\Controller;


use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use DateTime;
use ReCaptcha\ReCaptcha;
use SUSC\Form\ResetPasswordForm;
use SUSC\Model\Entity\RegistrationCode;
use SUSC\Model\Entity\User;
use SUSC\Model\Table\GroupsTable;

/**
 * Class UsersController
 * @package SUSC\Controller
 *
 * @property GroupsTable $Groups
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['register', 'logout', 'activateAccount', 'forgotPassword', 'resetPassword', 'verifyEmailChange']);
    }


    public function initialize()
    {
        parent::initialize();

        $this->Groups = TableRegistry::get('Groups');
    }

    public function login()
    {
        if (!$this->request->is('post')) {
            return;
        }

        $user = $this->Auth->identify();
        if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->Flash->error('Invalid username and/or password.');
        $this->request->withData('password', '');

    }

    public function logout()
    {
        $this->Flash->success(__('You have successfully logged out'));
        $this->redirect($this->Auth->logout());
    }

    /**
     * Handles user profile view (+ updating name)
     */
    public function profile()
    {
        $user = $this->currentUser;
        $this->viewBuilder()->setTemplate('user_profile');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your profile has been updated!'));
            } else {
                $this->Flash->error(__('Your profile could not be updated. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Handles password changing
     */
    public function changePassword()
    {
        /** @var User $user */
        $user = $this->currentUser;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity(
                $user,
                [
                    'old_password' => $this->request->getData('old_password'),
                    'password' => $this->request->getData('new_password'),
                    'new_password' => $this->request->getData('new_password'),
                    'conf_password' => $this->request->getData('conf_password'),
                    'is_change_password' => false
                ],
                [
                    'validate' => 'changePassword',
                    'guard' => false
                ]
            );
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your password has been changed!'));

                $email = new Email();
                $email
                    ->setTo($user->email_address, $user->full_name)
                    ->setSubject('Password Changed')
                    ->setViewVars(['user' => $user])
                    ->setTemplate('change_password')
                    ->send();
            } else {
                $this->Flash->error(__('Your password could not be changed. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Handles user account activation
     * @return \Cake\Http\Response|null
     */
    public function activateAccount()
    {
        $this->set('activationCode', $this->request->getQuery('activation_code'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $token = $this->request->getData('activation_code');
            $result = $this->Users->find('activationCode', ['activation_code' => $token]);
            if ($result->count() == 0) {
                $this->Flash->error(__('Account activation failed. Code not recognised.'));
                return;
            }

            /** @var User $user */
            $user = $result->first();
            $this->Users->patchEntity(
                $user,
                [
                    'activation_code' => null,
                    'activation_date' => Time::now(),
                    'is_active' => true
                ],
                ['guard' => false]
            );
            if ($this->Users->save($user)) {
                $email = new Email();
                $email
                    ->setTo($user->email_address, $user->full_name)
                    ->setSubject('Account Activated')
                    ->setViewVars(['user' => $user])
                    ->setTemplate('activated')
                    ->send();

                $this->Flash->success(__('Account was successfully activated!'));
                return $this->redirect(Router::url(['_name' => 'login']));
            } else {
                $this->log($user->getErrors());
                $this->Flash->error(__('Account activation failed. A server error occurred.'));
            }
        }
    }

    /**
     * Handles user email address change
     */
    public function changeEmail()
    {
        /** @var User $user */
        $user = $this->currentUser;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $now = new DateTime;
            $timestamp = $now->getTimestamp();
            $code = sha1(
                    $timestamp . $this->request->getData('new_email')
                ) . sha1(
                    $timestamp . $user->full_name
                );

            $user = $this->Users->patchEntity(
                $user,
                [
                    'password' => $this->request->getData('password'),
                    'new_email' => $this->request->getData('new_email'),
                    'conf_email' => $this->request->getData('conf_email'),
                    'new_email_code' => $code,
                    'new_email_code_date' => $now
                ],
                ['validate' => 'changeEmail']
            );
            if ($this->Users->save($user)) {
                $email = new Email();
                $email
                    ->setTo($user->new_email, $user->full_name)
                    ->setSubject('Verify Email Address')
                    ->setViewVars(['user' => $user, 'code' => $code])
                    ->setTemplate('change_email')
                    ->send();
                $this->Flash->success(__('An email has been sent to "' . $user->new_email . '", please click on the link to verify your email address.'));
            } else {
                $this->Flash->error(__('Your email address could not be changed.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function verifyEmailChange($code){
        try {
            /** @var User $user */
            $user = $this->Users->find('changeEmail', ['code' => $code])->firstOrFail();

            if(!$user->isChangeEmailValid()){
                $this->Flash->error(__('Verification code has expired'));
                return $this->redirect(['_name' => 'change_email']);
            }

            $user->setAccess('email_address', true);

            $this->Users->patchEntity($user, [
                'email_address' => $user->new_email,
                'new_email_code' => null,
                'new_email_code_date' => null,
                'new_email' => null
            ]);

            if($this->Users->save($user)){
                $email = new Email();
                $email
                    ->setTo($user->email_address, $user->full_name)
                    ->setSubject('Email Address Changed')
                    ->setViewVars(['user' => $user])
                    ->setTemplate('change_email_complete')
                    ->send();
                $this->Flash->success(__('Your email address was changed!'));
            } else {
                $this->Flash->error(__('Failed to change email address. Please try again.'));
            }
            return $this->redirect(['_name' => 'change_email']);
        } catch (RecordNotFoundException $ex){
            $this->Flash->error(__('Email address verification failed.'));
            return $this->redirect(['_name' => 'change_email']);
        }
    }

    /**
     * Handles user registration
     */
    public function register()
    {
        // Get registration code from get Param
        $this->set('registrationCode', $this->request->getQuery('code'));

        if (!$this->request->is(['patch', 'post', 'put'])) {
            return;
        }

        // Handle recaptcha
        $recaptcha = new ReCaptcha(Configure::read('Recaptcha.secret'));
        $recaptchaResponse = $recaptcha->verify($this->request->getData('g-recaptcha-response'), $this->request->clientIp());

        if (!$recaptchaResponse->isSuccess()) {
            foreach ($recaptchaResponse->getErrorCodes() as $error) {
                $this->Flash->error($error);
            }
            return;
        }

        $codes = TableRegistry::get('RegistrationCodes');
        try {
            /** @var RegistrationCode $registration_code */
            $registration_code = $codes->get($this->request->getData('registration_code'));

            if (!$registration_code->isValid()) {
                $this->Flash->error('An error occurred whilst creating your account. Code invalid');
                return;
            }


            $now = new DateTime;
            $timestamp = $now->getTimestamp();
            $activation_code = sha1(
                    $timestamp . $this->request->getData('email_address')
                ) . sha1(
                    $timestamp . $this->request->getData('first_name') . ' ' . $this->request->getData('last_name')
                );

            /** @var User $user */
            $user = $this->Users->newEntity([
                'group_id' => $registration_code->group_id,
                'first_name' => $this->request->getData('first_name'),
                'last_name' => $this->request->getData('last_name'),
                'password' => $this->request->getData('password'),
                'activation_code' => $activation_code
            ], ['guard' => false]);

            $user->setAccess('email_address', true);
            $user->email_address = $this->request->getData('email_address');

            if ($this->Users->save($user)) {
                $email = new Email();
                $email
                    ->setTo($user->email_address, $user->full_name)
                    ->setSubject('Activate Account')
                    ->setViewVars(['user' => $user, 'activation_code' => $activation_code])
                    ->setTemplate('activate_account')
                    ->send();

                $this->Flash->success(__('Your account has been created. To activate your account, please click the link sent to you.'));
                return $this->redirect(['_name' => 'activate']);
            }

            if (count($user->getError('email_address')) != 0) {
                $this->Flash->error('Email address is already registered. <a href="' . Router::url(['_name' => 'reset']) . '">Forgotten your password?</a>', ['escape' => false]);
            } else {
                $this->Flash->error(__('An error occurred whilst creating your account.'));
            }

        } catch (RecordNotFoundException $ex) {
            $this->Flash->error('An error occurred whilst creating your account. Code invalid');
        }
    }

    /**
     * Handles password loss
     */
    public function forgotPassword()
    {
        if (!$this->request->is(['patch', 'post', 'put'])) {
            return;
        }

        // Handle recaptcha
        $recaptcha = new ReCaptcha(Configure::read('Recaptcha.secret'));
        $recaptchaResponse = $recaptcha->verify($this->request->getData('g-recaptcha-response'), $this->request->clientIp());

        if (!$recaptchaResponse->isSuccess()) {
            foreach ($recaptchaResponse->getErrorCodes() as $error) {
                $this->Flash->error($error);
            }
            return;
        }

        try {
            /** @var User $user */
            $user = $this->Users->find('email', ['email_address' => $this->request->getData('email_address')])->firstOrFail();

            $now = new DateTime;
            $timestamp = $now->getTimestamp();
            $code = sha1(
                    $timestamp . $user->email_address
                ) . sha1(
                    $timestamp . $user->full_name
                );

            $this->Users->patchEntity($user, ['reset_code' => $code, 'reset_code_date' => $now], ['guard' => false]);

            if ($this->Users->save($user)) {
                $email = new Email();
                $email
                    ->setTo($user->email_address, $user->full_name)
                    ->setSubject('Reset Password')
                    ->setViewVars(['user' => $user, 'reset_code' => $code])
                    ->setTemplate('reset_password')
                    ->send();
            } else {
                $this->Flash->error('An error occurred whilst generating reset code. Please try again.');
                return;
            }

        } catch (RecordNotFoundException $ex) {

        }

        $this->Flash->success('If that email address has an account registered, you will receive an email shortly. If you do not receive an email within 30 minutes, try again.');
    }

    public function resetPassword($reset_code)
    {
        $resetForm = new ResetPasswordForm();
        /** @var User $user */
        $user = null;

        // Check reset code is valid
        try {
            $user = $this->Users->find('passwordReset', ['reset_code' => $reset_code])->firstOrFail();

            // Check it is in-time (hasn't expired)
            if (!$user->isResetPasswordValid()) {
                $this->Flash->error('Looks like the password reset link is invalid. Please try again.');
                return $this->redirect(['_name' => 'reset']);
            }
        } catch (RecordNotFoundException $ex) {
            $this->Flash->error('Looks like the password reset link is invalid. Please try again.');
            return $this->redirect(['_name' => 'reset']);
        }

        if (!$this->request->is(['patch', 'post', 'put']) || $user === null) {
            $this->set('resetForm', $resetForm);
            return;
        }

        // Handle recaptcha
        $recaptcha = new ReCaptcha(Configure::read('Recaptcha.secret'));
        $recaptchaResponse = $recaptcha->verify($this->request->getData('g-recaptcha-response'), $this->request->clientIp());

        if (!$recaptchaResponse->isSuccess()) {
            foreach ($recaptchaResponse->getErrorCodes() as $error) {
                $this->Flash->error($error);
            }
            $this->set('resetForm', $resetForm);
            return;
        }

        if (!$resetForm->validate($this->request->getData())) {
            $this->set('resetForm', $resetForm);
            return;
        }

        $this->Users->patchEntity($user,
            [
                'password' => $this->request->getData('new_password'),
                'reset_code_date' => null,
            ],
            ['guard' => false]
        );

        $user->reset_code = null;

        if ($this->Users->save($user)) {
            $email = new Email();
            $email
                ->setTo($user->email_address, $user->full_name)
                ->setSubject('Password Changed')
                ->setViewVars(['user' => $user])
                ->setTemplate('change_password')
                ->send();
            $this->Flash->success("Your password was changed!");
            return $this->redirect(Router::url(['_name' => 'login']));
        } else {
            $this->Flash->error("An error occurred whilst setting your password. Please try again.");
        }

    }
}