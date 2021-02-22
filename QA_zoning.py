import mysql.connector
import re

cnx = mysql.connector.connect(user='lcbiusr', password='bIUsR#231', host='192.168.1.208', database='newdatasets')
cur = cnx.cursor()

listtopublish_query = "select * from listtopublish where pub_Id='87220' "

# "select * from listtopublish where  PUB_EDITDate > '2021-02-01 07:08:21' and PUB_EDITDate < " \
#                       "'2021-02-02 23:27:30' and PUB_FP_Para_0 <> 'New Record'" \
#                       " and  PUB_Zone_Proposed is not null and  PUB_Zone_TO is not null; "
# select * from listtopublish where pub_id=85691
cur.execute(listtopublish_query)
listtopublish_record = cur.fetchall()
for record_list in listtopublish_record:
    pub_id = record_list[0]
    pub_para = record_list[14].casefold()
    # print(pub_para)
    proposedZoneChange = record_list[30].casefold()
    PUB_Address_Location = record_list[57].casefold()
    # print(PUB_Address_Location)
    PUB_Zone_TO = record_list[33].casefold()
    pub_para = re.sub(r'[?|$|.|!]', r'', pub_para)
    pub_para = re.sub(r'[^a-zA-Z0-9 ]', r'', pub_para)
    PUB_Address_Location = re.sub(r'[?|$|.|!]', r'', PUB_Address_Location)
    PUB_Address_Location = re.sub(r'[^a-zA-Z0-9 ]', r'', PUB_Address_Location)
    proposedZoneChange = re.sub(r'[?|$|.|!]', r'', proposedZoneChange)
    proposedZoneChange = re.sub(r'[^a-zA-Z0-9 ]', r'', proposedZoneChange)
    PUB_Zone_TO = re.sub(r'[?|$|.|!]', r'', PUB_Zone_TO)
    PUB_Zone_TO = re.sub(r'[^a-zA-Z0-9 ]', r'', PUB_Zone_TO)

    # PUB_Zone_from = record_list[33]
    if proposedZoneChange is not None:
        proposedZoneChange = proposedZoneChange.split()
        PUB_Zone_TO = PUB_Zone_TO.split()
        PUB_Address_Location = PUB_Address_Location.split()
        PUB_Zone_from = record_list[33].split()
        if all(word in pub_para for word in PUB_Address_Location):
            # print("matched in address")
            if all(word in pub_para for word in proposedZoneChange):
                # print("matched in proposedZoneChange")
                if all(word in pub_para for word in PUB_Zone_TO):
                    print("matched in PUB_Zone_TO")
                else:
                    print("pubPAra0 not PUB_Zone_TO1:" + str(pub_id))
            else:
                print("pubPAra0 not proposedZoneChange:" + str(pub_id))
        else:
                print("pubPAra0 not address:" + str(pub_id))

# PUB_Address_Location = '(XX113 010A) Pleasant Hill Church Road SE, Winder, GA 30680.';
# proposedZoneChange = 'to rezone 8.25 acres to R-1 Residential to combine with adjoining property.';
# words_zonechange = proposedZoneChange.split()
# words_location = PUB_Address_Location.split()
# if all(word in pub_para for word in words_location):
#     print("matched in address")
#     if all(word in pub_para for word in words_zonechange):
#         print("matched in zone")
#     else:
#         print("didnt match in zone")
# else:
#     print("didnt match in address")
# if all(wordZone in pub_para_o for wordZone in words_zonechange):
#     print("matched in zone")

# pub_para_o = 'RZ 2020–001- Frank B. Sanders, applicant / owner. (XX113 010A) Pleasant Hill Church  Road SE, Winder, GA 30680. Request to rezone 8.25 acres to R-1 Residential to combine with adjoining property. ';
# PUB_Address_Location = '(XX113 010A) Pleasant Hill Church Road SE, Winder, GA 30680.';
# proposedZoneChange = ' to rezone 8.25 acres to R-1 Residential to combine with adjoining property.';
# words_zonechange = proposedZoneChange.split()
# words_location = PUB_Address_Location.split()
#
# if all(word in pub_para_o for word in words_location):
#     print("matched in address")
#     if all(wordZone in pub_para_o for wordZone in words_zonechange):
#         print("matched in zone")
# else:
#     print("missing")
