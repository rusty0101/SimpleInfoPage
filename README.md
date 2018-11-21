A Simple Info Page
------------------

This started out as a page to present information to people at the Volunteer 
desk at Convergence. It uses simple CSV files to store data about events that 
are either presented on the day of the event in the next couple of hours, or all
the events in the 'content.csv' file. As a result you can either present what's 
coming up shortly, or you can fill the content.csv file with events over the 
next week, or month, or whatever timeframe you would like.

As the basic process of loading the csv is to read the file in a line at a time
and only keep the lines that are of interest, it would be possible to modify 
the iframes.html and or iframes2.html files to access content from other sources
including databases, other file types that are handled by php, or even web
queries that result in properly formatted information.

Two sub directories exist, log and logneeds. These are the locations for content
being presented by the crawls at the top, or the bottom of the page. The only 
real difference between the two is what's in the qlog.txt file. Presumedly you 
are looking for different content in each of these. There are two html files in 
each directory. elog.html allows you to add log entries. qlog.html gives you
the ability to remove entries as well. Depending on your needs, the result may
be a simple log or journal program on it's own.

The clock is a simple javascript clock. 

The index.html and dindex.html files are essentially 'go away' files for users
who attempt to just browse into the directory. It is presumed that you are going
to run this in some variety of kiosk and that you will set it up to open a web
browser full screen with the URL of the appropriate iframes or iframes2 file 
that you want presented.

