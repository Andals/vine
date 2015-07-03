sci_path=`dirname $0`
cur_path=$sci_path

cd $cur_path/../
prj_home=`pwd`

cd $prj_home
if [ -d tmp ]
then
	rm -rf tmp/cscope*
else
	mkdir tmp
fi

csfile=$prj_home/tmp/cscope.files

find $prj_home/ -name "*.php" >  $csfile
find $prj_home/ -name "*.html" >> $csfile
find $prj_home/ -name "*.htm" >>  $csfile
find $prj_home/ -name "*.sh" >>   $csfile
find $prj_home/ -name "*.inc" >>  $csfile
find $prj_home/ -name "*.sql" >>  $csfile
find $prj_home/ -name "*.js" >>   $csfile
find $prj_home/ -name "*.css" >>  $csfile
find $prj_home/ -name "*.conf" >> $csfile
find $prj_home/ -name "*.tpl" >>  $csfile
find $prj_home/ -name "*.c" >>  $csfile
find $prj_home/ -name "*.h" >>  $csfile

cd $prj_home/tmp
cscope -bq  -i $csfile
