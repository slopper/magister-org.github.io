<?php

class Config
{
    // �������� �� ������� � ������ �������� free-kassa.ru
    const MERCHANT_ID = '63165';
    const SECRET_KEY_1 = 'jxvcpieg';
    const SECRET_KEY_2 = 'clyz8tki';
    
    // ��������� ������ � ���.
    const ITEM_PRICE = 1;

    // ������� ���������� ������, �������� `users`
    const TABLE_ACCOUNT = 'users';
    // �������� ���� �� ������� ���������� ������ �� �������� ������������ ����� ��������/�����, �������� `email`
    const TABLE_ACCOUNT_NAME = 'id';
    // �������� ���� �� ������� ���������� ������ ������� ����� ��������� �� ��������� ���������� ������, �������� `sum`, `donate`
    const TABLE_ACCOUNT_DONATE= 'balance';

    // ��������� ���������� � ��
    // ����
    const DB_HOST = 'localhost';
    // ��� ������������
    const DB_USER = 'u0434717_beta123';
    // ������
    const DB_PASS = 'beta123q';
    // �������� ����
    const DB_NAME = 'u0434717_beta';
}