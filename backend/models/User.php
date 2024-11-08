<?php
class User {
    public $user_id;
    public $username;
    public $password;
    public $role_id;

    public function __construct($data = []) {
        $this->user_id = $data['user_id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->role_id = $data['role_id'] ?? null;
    }

    public function toArray() {
        return [
            'user_id' => $this->user_id,
            'username' => $this->username,
            'role_id' => $this->role_id,
        ];
    }
}
