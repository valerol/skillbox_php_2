<?php
namespace App\Controllers;

use App\View\View;
use App\Model\User;
use App\Model\Subscription;

/**
 * Class SubscriptionsController
 * @package App\Controllers
 */
class SubscriptionsController
{
    /**
     * @param string $params
     * @return View
     */
    public function subscriptionList(string $params = '') : View
    {
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

        if (!empty($subscription->email)) {
            $user = User::getByEmail($subscription->email);

            if ($user && $user->subscribed == 1) {
                User::setSubscribed($user->id, 0);
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
        $email = Subscription::getEmailById($id);

        $user = User::getByEmail($email);

        if (!empty($user) && $user->subscribed == 1) {
            User::setSubscribed($user->id, 0);
        }

        Subscription::removeById($id);

        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/subscriptions/');
    }
}
