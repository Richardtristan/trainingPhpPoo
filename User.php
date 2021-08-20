<?php

class User
{
    /**
     * @var int
     * id of the user in DTB
     */
    private $id;
    /**
     * @var string
     * Username of the user in DTB
     */
    private $username;
    /**
     * @var string
     * email of the user in DTB
     */
    private $email;
    /**
     * @var string
     * password of the user in DTB
     */
    private $password;
    /**
     * @var string
     * return if the user is connected or not
     */
    private $connected;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $username, string $email, string $password)
    {
        global $db;
        $this->db = $db;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->connected = isset($_SESSION['userid']);
    }

    function createUser()
    {
        $user = $this->db->prepare("INSERT INTO users(username, email, password) VALUES (?,?,?)");
        $user->execute([$this->username, $this->email, $this->password]);

    }

    function upDateUser($username, $email, $password, $id)
    {
        $user = $this->db->prepare("UPDATE users SET username = ? , email = ? , password = ?  WHERE id = ?");
        $user->execute([$username, $email, $password, $id]);

    }

    function emailExist()
    {
        $email = $this->db->prepare("SELECT email FROM users WHERE email = ?");
        $email->execute([$this->email]);
        $emailExiste = $email->fetch();
        return $emailExiste;
    }

    function UsernameExist()
    {
        $username = $this->db->prepare("SELECT username FROM users WHERE username = ?");
        $username->execute([$this->username]);
        $user = $username->fetch();
        return $user;
    }

    public function UpdateUserExist($post)
    {
        $usernameUpdate = $this->db->prepare("SELECT username FROM users WHERE username = ?");
        $usernameUpdate->execute([$post]);
        $userUpdate = $usernameUpdate->fetch();
        return $userUpdate;
    }

    public function UpdateEmailExist($post)
    {
        $EmailUpdate = $this->db->prepare("SELECT username FROM users WHERE username = ?");
        $EmailUpdate->execute([$post]);
        $mailUpdate = $EmailUpdate->fetch();
        return $mailUpdate;
    }

    public function logout()
    {
// On démarre la session
        session_start();

// On détruit les variables de notre session
        session_unset();

// On détruit notre session
        session_destroy();

// On redirige le visiteur vers la page d'accueil
        header('location: index.php');
    }

    public function delete($id, $passwordPost, $session)
    {
        $user = $this->db->prepare("DELETE FROM users   WHERE id = ?");
        $user->execute([$id]);
        $userExist = $user->fetch();

        if ($userExist) {
            if ($userExist['password'] === password_verify($session, $passwordPost)) {
                return true;
            }
        }
        return false;
    }

}


?>