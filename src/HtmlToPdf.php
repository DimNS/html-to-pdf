<?php
/**
 * Create a pdf file from html string
 *
 * @version 2019-06-11
 * @author  DimNS <dimns@dimns.ru>
 */

namespace DimNS\HtmlToPdf;

use Mpdf\Mpdf;
use Mpdf\MpdfException;

/**
 * Class HtmlToPdf
 *
 * @package DimNS\HtmlToPdf
 */
class HtmlToPdf
{
    /**
     * @var array Default settings
     */
    protected $mpdf_config = [
        'format'              => 'A4',
        'orientation'         => 'portrait',
        'default_font'        => 'arial',
        'setAutoTopMargin'    => 'stretch',
        'setAutoBottomMargin' => 'stretch',
    ];

    /**
     * @var string Path to the folder where the file will be placed
     */
    protected $path_to_folder = null;

    /**
     * HtmlToPdf constructor.
     *
     * @param string $path_to_folder Path to the folder where the file will be placed
     * @param array  $mpdf_config    Redefining Mpdf settings
     *
     * @author  DimNS <dimns@dimns.ru>
     * @version 2019-06-11
     */
    public function __construct($path_to_folder, $mpdf_config = [])
    {
        $this->mpdf_config = array_merge($this->mpdf_config, $mpdf_config);
        $this->path_to_folder = $this->preparePathToFolder($path_to_folder);
    }

    /**
     * Create a pdf document
     *
     * @param string $html_body   Content
     * @param string $html_header Header
     * @param string $html_footer Footer
     *
     * @return string
     *
     * @throws MpdfException
     *
     * @author  DimNS <dimns@dimns.ru>
     * @version 2019-06-11
     */
    public function create($html_body, $html_header = null, $html_footer = null)
    {
        $filename = $this->path_to_folder . md5($html_body) . '.pdf';

        $mpdf = new Mpdf($this->mpdf_config);

        if (!empty($html_header)) {
            $mpdf->SetHTMLHeader($html_header);
        }

        if (!empty($html_footer)) {
            $mpdf->SetHTMLFooter($html_footer);
        }

        $mpdf->WriteHTML($html_body);
        $mpdf->Output($filename, 'F');

        return $filename;
    }

    /**
     * Preparing the name of the folder
     *
     * @param string $path_to_folder Path to the folder where the file will be placed
     *
     * @return string
     *
     * @author  DimNS <dimns@dimns.ru>
     * @version 2019-06-11
     */
    protected function preparePathToFolder($path_to_folder)
    {
        $last_symbol = substr($path_to_folder, -1);

        if ($last_symbol === '/' || $last_symbol === '\\') {
            return $path_to_folder;
        }

        return $path_to_folder . DIRECTORY_SEPARATOR;
    }
}
