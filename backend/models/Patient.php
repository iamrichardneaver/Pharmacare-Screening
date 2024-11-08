<?php
class Patient {
    public $patient_id;
    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $gender;
    public $address;
    public $phone_number;
    public $email;

    public function __construct($data = []) {
        $this->patient_id = $data['patient_id'] ?? null;
        $this->first_name = $data['first_name'] ?? '';
        $this->last_name = $data['last_name'] ?? '';
        $this->date_of_birth = $data['date_of_birth'] ?? '';
        $this->gender = $data['gender'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->phone_number = $data['phone_number'] ?? '';
        $this->email = $data['email'] ?? '';
    }

    public function toArray() {
        return [
            'patient_id' => $this->patient_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
        ];
    }

    public function validate() {
        $errors = [];

        if (empty($this->first_name)) {
            $errors[] = "First name is required";
        }
        if (empty($this->last_name)) {
            $errors[] = "Last name is required";
        }
        if (empty($this->date_of_birth)) {
            $errors[] = "Date of birth is required";
        }
        if (empty($this->gender)) {
            $errors[] = "Gender is required";
        }
        if (!empty($this->email) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        return $errors;
    }
}
