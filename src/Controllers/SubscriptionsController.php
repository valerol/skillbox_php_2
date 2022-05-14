<?php
namespace App\Controllers;

use App\View\View;
use App\Model\User;
use App\Model\Subscription;

/**
 * Class SubscriptionsController
 * @package App\Controllers
 */
class SubscriptionsController extends AbstractAccessController
{
    /**
     * @param string $params
     * @return View
     */
    public function subscriptionList(string $params = '') : View
    {
        $this->checkAccess(10);

        $pagination = new Pagination('Subscription', $params);

        return new View('admin.view.subscriptions', ['title' => 'Подписки', 'subscriptions' => $pagination->getData(),
            'pagination' => $pagination]);
    }

    /**
     * @param string $nonce
     * @return View
     */
    public function unsubscribeAction(string $nonce) : View
    {
        $errors = [];
        $subscription = Subscription::getByNonce($nonce);

        if ($subscription && !empty($subscription->email)) {
            $user = User::getByEmail($subscription->email);

            if ($user && $user->subscribed == 1) {
                User::unsubscribe($user->id);
            }

            Subscription::removeById($subscription->id);
        } else {
            $errors[] = "Похоже, Вы не были подписаны";
        }

        return new View('view.unsubscribe', ['title' => 'Отписка', 'errors' => $errors]);
    }

    /**
     * @param int $id
     */
    public function subscriptionDelete(int $id)
    {
        $this->checkAccess(10);

        $email = Subscription::getEmailById($id);

        $user = User::getByEmail($email);

        if (!empty($user) && $user->subscribed == 1) {
            User::unsubscribe($user->id);
        }

        Subscription::removeById($id);

        $this->redirect('/admin/subscriptions/');
    }
}
