<?php
	header('Content-type:application/force-download');
	header('Content-Transfer-Encoding: Binary');
	header('Content-Disposition:attachment;filename=image2pdf.qpkg');
	@readfile('./image2pdf.qpkg');