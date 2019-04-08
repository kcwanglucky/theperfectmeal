
# coding: utf-8

# In[ ]:

import urllib
from bs4 import *

ans = []

def loop(url):
    html = urllib.urlopen(url).read()
    soup = BeautifulSoup(html)
    #print soup
    tags = soup('a')
    ans.append(tags[17].contents[0])
    return tags[17].get("href", None)

url = "http://python-data.dr-chuck.net/known_by_Caitaidh.html"
html = urllib.urlopen(url).read()
soup = BeautifulSoup(html)
tags = soup('a')
#print tags[17].get("href", None)
#ans.append(tags[17].contents[0])

for i in range(0, 7):
    url = loop(url)

print ans


# In[ ]:




# In[5]:

import requests
import pandas as pd
#import urllib
from bs4 import BeautifulSoup
res = requests.get("https://www.yelp.com/search?find_desc=&find_loc=Champaign%2C+IL&ns=1")
soup = BeautifulSoup(res.text)
reups = soup.select('.indexed-biz-name span')
reup1s = soup.select('address')
series.apply(reup1s)
print d
for reup in reups:
    print reup.contents[0]
for reup1 in reup1s:
    print reup1.contents[0]
#print reup.select('.indexed-biz-name')
#print tags
#for tag in tags:
 #   print tag.text.strip()
#tags = reup('.indexed-biz-name')
#print tags
#for tag in tags:
 #   print tag.text.strip()


# In[3]:

html = urllib.urlopen("https://www.yelp.com/search?find_loc=Champaign,+IL&start=10").read()
soup = BeautifulSoup(html)
Sorts = soup.findAll('span', class_='category-str-list')
Sort_lists={}

for Sort in Sorts:
    cats = Sort.findAll('a')
    for cat in cats:
        print cat.text,
    print ""


# In[22]:

import urllib
from bs4 import BeautifulSoup
from sqlalchemy import create_engine
url = "https://www.yelp.com/search?find_desc=&find_loc=Champaign%2C+IL&ns=1"
url1 = "https://www.yelp.com/search?find_loc=Champaign,+IL&start="
html = urllib.urlopen(url).read()
soup = BeautifulSoup(html)
reups = soup.findAll('span', class_='indexed-biz-name')
i = 1
Base_URL = "https://www.yelp.com"
restaurant_lists=[] #store the restaurants' yelp page
restaurant_websites=[]

for reup in reups:
    #print i,".", reup.find('span').text
    restaurant_lists.append(Base_URL + reup.find('a').get('href'))
    #restaurant_websites.append(Base_URL + reup.find('href'))
    i += 1;

for i in range(10, 400, 10):
    html = urllib.urlopen(url1+str(i)).read()
    soup = BeautifulSoup(html)
    reups = soup.findAll('span', class_='indexed-biz-name')
    for reup in reups:
        #print i,".", reup.find('span').text
        restaurant_lists.append(Base_URL + reup.find('a').get('href'))
        i += 1;


df = pd.DataFrame({'URL': restaurant_lists})
#df.to_sql('data', engine)
df.to_csv('data2.csv', index=False)
#print reups
#for i in range(0, len(reup)):
#    print reup[i].select('span').text


# In[20]:

import urllib
import csv
import numpy as np
import pandas as pd

from bs4 import BeautifulSoup
from sqlalchemy import create_engine
with open("chicago.csv", 'rb') as f:
    datas = list(csv.reader(f))[1:]

photo_list=[]
i = 0
   
#'''
for data in datas:
    
    print i
    i=i+1
    url = data[0]
    html = urllib.urlopen(url).read()
    soup = BeautifulSoup(html)
    
    if (soup.find('img', class_="photo-box-img") != None):
        photo = soup.find('img', class_="photo-box-img").get("src")
        photo_list.append(photo)
    else:
        photo_list.append(None)
'''
url=datas[0][0]

html = urllib.urlopen(url).read()
soup = BeautifulSoup(html)
reups = soup.find('img', class_="photo-box-img").get("src")

print reups
'''
df = pd.DataFrame({'photo': photo_list})
df.to_csv('photo_chicago.csv', index=False, mode='a', columns=['photo'])
#'''


# In[288]:

import urllib
import csv
import numpy as np
import pandas as pd

from bs4 import BeautifulSoup
from sqlalchemy import create_engine
#url = "https://www.yelp.com/search?find_desc=&find_loc=Champaign%2C+IL&ns=1"
#url1 = "https://www.yelp.com/search?find_loc=Champaign,+IL&start="
#html = urllib.urlopen(url).read()
#soup = BeautifulSoup(html)
#reups = soup.findAll('span', class_='indexed-biz-name')


with open("chicago.csv", 'rb') as f:
    #datas = list(csv.reader(f))[1:]
    datas = list(csv.reader(f))[900:990]
    
res_name=[]
res_website=[]
res_yelp_page=[]
res_address=[]
res_phone=[]
res_review=[]
res_rating=[]
res_price=[]
res_category=[]
res_menu_website=[]   #need crawl
res_credit=[]
res_delivery=[]
res_hour=[]
i=0
   
#'''
for data in datas:
    print i
    i=i+1
    url = data[0]
    html = urllib.urlopen(url).read()
    soup = BeautifulSoup(html)

    name = soup.find('h1').text.strip().encode('ascii', 'ignore')
    res_name.append(name)
    
    if (soup.find('span', class_="biz-website") != None):
        website = soup.find('span', class_="biz-website").a.text.encode('ascii', 'ignore')
        res_website.append(website)
    else:
        res_website.append(None)
    
    res_yelp_page.append(data[0])
    
    if (soup.find('strong', class_='street-address').address != None):
        addr = soup.find('strong', class_='street-address').address.text.strip()
        res_address.append(addr)
    else: 
        res_address.append(soup.find('strong', class_='street-address'))

    if (soup.find('span', class_="biz-phone") != None):
        phone = soup.find('span', class_="biz-phone").text.strip()
        res_phone.append(phone)
    else:
        res_phone.append(None)
    
    if(soup.find('span', class_="review-count") != None):
        review = int(soup.find('span', class_="review-count").text.strip().split()[0])
        res_review.append(review)
    else:
        res_review.append(0)

    if(soup.find('img', class_="offscreen").get('alt') != None):
        rating = int(float(soup.find('img', class_="offscreen").get('alt').split()[0]))
        res_rating.append(rating)
    else:
        res_rating.append(None)

    if (soup.find('span', class_="business-attribute price-range") != None):
        price = int(len(soup.find('span', class_="business-attribute price-range").text))
        res_price.append(price)
    else:
        res_price.append(None)

    category = soup.find('span', class_="category-str-list").text.replace(',', '').strip().split()
    category_string = ''.join(category)
    res_category.append(category_string)


    if(soup.find('a', class_="external-menu") != None):
        website = soup.find('div', class_="island summary").a.get('href')
        res_menu_website.append(website)
    else:
        res_menu_website.append(None)

    if(soup.find('div', class_="short-def-list") != None):
        if(len(soup.find('div', class_="short-def-list").text.replace(' ', '').split()) > 8):
            credit = soup.find('div', class_="short-def-list").text.replace(' ', '').split()[7]
            res_credit.append(credit)
        else:
            res_credit.append('Yes')
    else:
        res_credit.append('No')
            
    
    if(soup.find('div', class_="short-def-list") != None):
        if(len(soup.find('div', class_="short-def-list").text.replace(' ', '').split()) > 8):
            delivery = soup.find('div', class_="short-def-list").text.replace(' ', '').split()[3]
            res_delivery.append(delivery)
        else:
            res_delivery.append('No')
    else:
        res_delivery.append('No')

    if(len(soup.find('div', class_="ywidget").text.replace(' ', '').strip().split()[1:-1]) != 0):
        hour = soup.find('div', class_="ywidget").text.replace(' ', '').strip().split()[1:-1]
        hour_string = ''.join(hour)
        res_hour.append(hour_string)
    else:
        res_hour.append(None)
    
'''
url=datas[11][0]

html = urllib.urlopen(url).read()
soup = BeautifulSoup(html)
reups = soup.find('span', class_="category-str-list").text.replace(',', '').strip().split()



print reups
'''

df = pd.DataFrame({'name': res_name, 'website': res_website, 'yelp_page':res_yelp_page, 'address': res_address, 'phone': res_phone, 'review': res_review, 'rating': res_rating, 'price': res_price, 'category': res_category, 'menu_website': res_menu_website, 'credit': res_credit, 'delivery': res_delivery, 'hour': res_hour})

df.to_csv('chicago7.csv', index=False, columns=['name','website','yelp_page','phone','review','price','category','address','delivery','hour','menu_website','rating','credit'])
#'''


# In[150]:

reups = soup.find('div', class_="mapbox-text")
reups = soup.find('div', class_="price-category")


# In[275]:

import urllib
from bs4 import BeautifulSoup
from sqlalchemy import create_engine
url = "https://www.yelp.com/search?find_loc=Chicago,+IL"
url1 = "https://www.yelp.com/search?find_loc=Chicago,+IL&start="
html = urllib.urlopen(url).read()
soup = BeautifulSoup(html)
reups = soup.findAll('span', class_='indexed-biz-name')
i = 1
Base_URL = "https://www.yelp.com"
restaurant_lists=[] #store the restaurants' yelp page
restaurant_websites=[]

for reup in reups:
    #print i,".", reup.find('span').text
    restaurant_lists.append(Base_URL + reup.find('a').get('href'))
    #restaurant_websites.append(Base_URL + reup.find('href'))
    i += 1;

for i in range(10, 990, 10):
    html = urllib.urlopen(url1+str(i)).read()
    soup = BeautifulSoup(html)
    reups = soup.findAll('span', class_='indexed-biz-name')
    for reup in reups:
        #print i,".", reup.find('span').text
        restaurant_lists.append(Base_URL + reup.find('a').get('href'))
        i += 1;


df = pd.DataFrame({'URL': restaurant_lists})
#df.to_sql('data', engine)
df.to_csv('chicago.csv', index=False)
#print reups
#for i in range(0, len(reup)):
#    print reup[i].select('span').text


# In[72]:

import pandas

cols=['name','website','yelp_page','phone','review','price','category','address','delivery','hour','menu_website','rating','credit']
a = pandas.read_csv('data4.csv')
a


# In[271]:

df = pd.DataFrame({'name': res_name, 'website': res_website, 'yelp_page':res_yelp_page, 'address': res_address, 'phone': res_phone, 'review': res_review, 'rating': res_rating, 'price': res_price, 'category': res_category, 'menu_website': res_menu_website, 'credit': res_credit, 'delivery': res_delivery, 'hour': res_hour})

df.set_value(18, 'hour', None)
#df.set_value('38', 'hour', None)
#df.set_value('75', 'test', None)
#df.set_value('76', 'test', None)
#df1 = df[90:100]
df
#df1.to_csv('test.csv', index=False)
#.to_csv('test.csv', index=False)


# In[272]:

df = pd.DataFrame({'name': res_name, 'website': res_website, 'yelp_page':res_yelp_page, 'address': res_address, 'phone': res_phone, 'review': res_review, 'rating': res_rating, 'price': res_price, 'category': res_category, 'menu_website': res_menu_website, 'credit': res_credit, 'delivery': res_delivery, 'hour': res_hour})
df.set_value(18, 'hour', None)
df.set_value(38, 'hour', None)
df.set_value(75, 'hour', None)
df.set_value(76, 'hour', None)
df.to_csv('champaign4.csv', index=False, columns=['name','website','yelp_page','phone','review','price','category','address','delivery','hour','menu_website','rating','credit'])


# In[1]:

restaurant_lists


# In[21]:


frame = pd.DataFrame()
list_ = []
for i in range(1, 8):
    filename = "chicago" + str(i) + ".csv"
    df = pd.read_csv(filename, index_col=None, header=0)
    list_.append(df)
frame = pd.concat(list_)


df1 = pd.read_csv("photo_chicago.csv", index_col=None, header=0)
list1_=[]
list1_.append(df1)
frame1 = pd.concat(list1_)

frame['photo'] = frame1
frame.to_csv('allrest_chicago.csv', index=False, columns=['name','website','yelp_page','phone','review','price','category','address','delivery','hour','menu_website','rating','credit', 'photo'])


