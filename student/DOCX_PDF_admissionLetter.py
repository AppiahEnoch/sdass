import sys
from docx2pdf import convert

def convert_docx_to_pdf(indexnumber):
    filename="ADM_"+indexnumber
    docx_file_path = f"../DOCX_LETTERS/{indexnumber}.docx"
    pdf_file_path = f"../PDF_LETTERS/{filename}.pdf"
    convert(docx_file_path, pdf_file_path)

if __name__ == "__main__":
    indexnumber = sys.argv[1]
    convert_docx_to_pdf(indexnumber)


