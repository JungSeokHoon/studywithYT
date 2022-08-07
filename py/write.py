from selenium import webdriver
import chromedriver_autoinstaller
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.keys import Keys
import sys
import time #자동화 속도가 로딩 시간보다 빠릅니다. 여유 시간을 둬야해요!
import pymysql
conn = pymysql.connect(host='localhost', user='root', password='sos65683629', db='studywithyt', charset='utf8')
cur = conn.cursor()

#크롬 드라이브 자동 업데이트
chrome_ver = chromedriver_autoinstaller.get_chrome_version().split('.')[0]  #크롬드라이버 버전 확인
chrome_options = Options()

try:
    driver = webdriver.Chrome(f'./{chrome_ver}/chromedriver.exe')
    driver = webdriver.Chrome(chrome_options=chrome_options)
except:
    chromedriver_autoinstaller.install(True)
    driver = webdriver.Chrome(f'./{chrome_ver}/chromedriver.exe')
    driver = webdriver.Chrome(chrome_options=chrome_options)

path = sys.argv[1]

driver.get('https://www.youtube.com/watch?v='+path)
time.sleep(1)
#스크립트 열기
driver.execute_script("document.querySelector('ytd-engagement-panel-section-list-renderer[target-id=\"engagement-panel-searchable-transcript\"]').setAttribute('visibility', 'ENGAGEMENT_PANEL_VISIBILITY_EXPANDED')")
driver.implicitly_wait(2)

time = []
sub = []
title = driver.find_element("xpath",'//title').get_attribute("innerText")

sublist = driver.find_elements("xpath",'//ytd-transcript-segment-renderer/div/yt-formatted-string') #게시글 Xpath
if(len(sublist) > 1):
    for s in sublist:
        sub.append(s.get_attribute("innerText"))
        print(s.get_attribute("innerText"))
        
    timelist = driver.find_elements("xpath",'//div[@class="segment-timestamp style-scope ytd-transcript-segment-renderer"]') #게시글 Xpath
    for t in timelist:
        time.append(t.get_attribute("innerText"))
        print(t.get_attribute("innerText"))
driver.implicitly_wait(2)
driver.quit()

sql = 'INSERT INTO board (videoid, title) VALUES ("'+path+'", "'+title+'")'
print(sql)
cur.execute(sql)
conn.commit()

sql = 'SELECT max(viewid) FROM board'
print(sql)
cur.execute(sql)
result = cur.fetchall()
viewid = result[0][0]
print(viewid)

if(len(sublist) > 1):
    #view 생성
    for i in range(0, len(time)):
        sql = 'insert into subtitle (viewid, time, sub) values('+str(viewid)+', "'+time[i]+'", "'+sub[i]+'")'
        print(sql)
        cur.execute(sql)

conn.commit()
conn.close()