### ˼�ǽݿƼ� refinephp ���ʹ��˵��

- refinephp ��һ�����easyswoole�Ŀ��ٿ�����php��ܣ���ԭ�е�easyswoole�Ļ�������ǿ�˶�ʱ��������Ͷ�ݵȹ��ܣ��������ò��������������·�ɲ������Լ�reqeust��response�Ȳ����ĸ�����

**Ŀ¼�ṹ˵��**

[TOCM]

[TOC]

��Ҫ���Ĺ���˵��
-------------

### Controller
                
----
* �����ռ䣺szjcomo\szjcore\Controller 

�����б�

|  ���� | ��������   | ����˵��  |  ����˵�� |
| ------------ | ------------ | ------------ | ------------ |
| public  | index()  | ��  | easyswoole �涨�̳��Կ���������ʵ��index����  |
| public  | session($key,$value)  | key,value  | ��ȡsession������session��ֵ  |
| public  | appResult($info,$data,$err)  | info,data,err  | ͳһapp����ֵ,info ����˵�� data������ err�Ƿ���ȷ  |
| public  | appJson($data,$code)  |data,code  | ��ӦJSON����,codeĬ����200  |
| public  | initialize()  |�� | ȫ�������¼�������Ȩ�޿�������������������ɣ�����false������ִ�к���ĳ��� ����true����ִ��  |
| public  | onRequest()  |�� | ��д��easyswoole��onRequest()�¼�����ǿ��context���ܣ�������������д���������ʵ��initialize()�¼�����  |
| public  | onException()  |�� | ��д��easyswoole��onException�¼����������������,ͳһ����json��ʽ������Ϣ  |
| public  | _emtpy($action)  |action | δ���󵽷����ղ�������,����ɸ���ҵ����Ҫ�Զ���ʵ��  |