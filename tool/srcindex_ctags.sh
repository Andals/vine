sci_path=`dirname $0`
cur_path=$sci_path

prj_home=$cur_path/../
ext_path=''

cd $prj_home
if [ -f 'tags' ]
then
    rm -f tags
fi

`which ctags` -R --exclude='*.css' --exclude='*.js' ./ $ext_path
