set nu
set nowrap
set background=dark
set encoding=utf-8
set fileencoding=utf-8

noremap <F3> <Esc>:TlistToggle <CR>
noremap <F8> <Esc>:! $PWD/tool/rigger/client/rigger.sh cmd=conf sys=all env=dev <CR> <Esc>:! $PWD/tool/rigger/client/rigger.sh cmd=restart env=dev <CR>
"noremap <F9> <Esc>:! $PWD/tool/srcindex_cscope.sh <CR> <Esc>: execute "cs add ".$PWD."/tmp/cscope.out" <CR>
noremap <F9> <Esc>:! $PWD/tool/srcindex_ctags.sh <CR>
