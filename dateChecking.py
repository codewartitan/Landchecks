import datetime
import re
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from webdriver_manager.chrome import ChromeDriverManager
import mysql.connector

cnx = mysql.connector.connect(user='lcbiusr', password='bIUsR#231', host='192.168.1.208', database='newdatasets')
cur = cnx.cursor()
#
driver = webdriver.Chrome(ChromeDriverManager().install())
mtgdt_query = "select mtgdt,fc_id,agendaurl,fc_typeofrecord,fc_msa from newdatasets.dailyprocessfiles where   (" \
              "agendaurl LIKE '%agendacenter%' and date(fc_date)='2021-04-05' )  or   (agendaurl LIKE '%iqm2%' and  " \
              "date(fc_date)='2021-04-05') or (agendaurl LIKE '%legistar%' and date(fc_date)='2021-04-05') "
cur.execute(mtgdt_query)
mtgdy_record = cur.fetchall()
for record_list in mtgdy_record:
    fc_id = record_list[1]
    URL = record_list[2]
    dept = record_list[3]
    msacode = record_list[4]
    driver.get(URL)
    if "AgendaCenter" in driver.current_url:
        try:
            meetingdate = driver.find_element_by_xpath("//table//td//a//strong[1]").text
            meetingdate1 = re.sub("[ ,.]", '', meetingdate)
            if meetingdate1 == 'Apr52021':
                print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + ":yes: " + URL)
            else:
                print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + ":no: " + URL)
        except NoSuchElementException:  # spelling error making this code not work as expected
            print(str(fc_id) + ":element not found: " + URL)
    if "iqm2" in driver.current_url:
        driver.get(URL)
        try:
            if driver.find_element_by_xpath("//a[contains(text(),'Apr 5, 2021 ')]"):
                print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + "yes: " + URL)
            else:
                print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + ":no: " + URL)
        except NoSuchElementException:  # spelling error making this code not work as expected
            print(str(fc_id) + ":element not found: " + URL)

    if "legistar" in driver.current_url:
        try:
            if driver.find_element_by_xpath('//td[contains(text(),"4/5/2021")]'):
                print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + " :yes : " + URL)
            else:
                print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + " :no : " + URL)

        except NoSuchElementException:  # spelling error making this code not work as expected
            print(str(msacode) + " : " + str(dept) + " : " + str(fc_id) + " : " + ":element not found: " + URL)

###iqm2##
# driver.get("http://willcountyil.iqm2.com/citizens/default.aspx")
# iqm2Meetindate = driver.find_element_by_xpath("//div[@class='RowLink'][1]").text
# iqm2Meetindate = re.sub("[ ,.]",'', iqm2Meetindate)
# print(iqm2Meetindate)
# if iqm2Meetindate=='Mar3120219:00AM':
#     print("yes")
# else:
#     print("no")
# try:
#     if driver.find_element_by_xpath("//a[contains(text(),'Feb 24, 2021 ')]"):
#         print("meeting is availle")
# except NoSuchElementException:  # spelling error making this code not work as expected
#         print("meeting date isn\'t available")
###iqm2##
driver.implicitly_wait(10)
driver.quit()
