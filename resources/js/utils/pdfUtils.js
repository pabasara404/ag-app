// src/utils/pdfUtils.js

import jsPDF from "jspdf";
import QRCode from 'qrcode';

const applicationTitles = {
    TCP: "Timber Cutting Permit",
    TTP: "Timber Transporting Permit",
    IBR: "Individual Business Registration Certificate",
    FR: "Firm Registration Certificate",
    IC: "Income Certificate",
    ATP: "Animal Transportation Permit",
    PF: "President Fund Application",
    MH: "Mahapola Application",
    EL: "Excise License Permit",
    VC: "Valuation Report",
};

function getApplicationTypeFromCode(applicationCode) {
    const parts = applicationCode.split('/');
    if (parts.length >= 3) {
        return parts[2];
    }
    return null;
}

export async function generateApplicationPDF(application) {
    try {
        const pdf = new jsPDF("p", "mm", "a4");
        const applicationType = getApplicationTypeFromCode(application.application_code);
        const applicationTitle = applicationTitles[applicationType] || "Application Details";

        let y = await addApplicationDetailsToPdf(pdf, applicationTitle, application);

        // Generate a QR code of the application code
        const qrCodeUrl = await QRCode.toDataURL(application.application_code);
        const qrCodeImage = new Image();
        qrCodeImage.src = qrCodeUrl;

        // Check if there's enough space left for the QR code
        if (y + 60 > pdf.internal.pageSize.height) {
            pdf.addPage();
            y = 20; // Reset y position
        }

        // Add the QR code image to the PDF
        pdf.addImage(qrCodeImage, 'JPEG', 10, y, 50, 50);

        return pdf;
    } catch (error) {
        console.error("Error generating PDF:", error);
        throw new Error("Error generating PDF");
    }
}

function addApplicationDetailsToPdf(pdf, applicationTitle, details) {
    let y = 20; // Starting y position for text
    const pageHeight = 297; // A4 page height in mm
    const margin = 10;
    const lineHeight = 7; // Adjust this value to change line spacing

    // Function to add a new page if the y position exceeds page height
    function checkPageBreak() {
        if (y >= pageHeight - margin) {
            pdf.addPage();
            y = margin;
        }
    }

    // Function to format values
    function formatValue(value) {
        if (typeof value === 'object' && value !== null) {
            if (Array.isArray(value)) {
                return value.map(v => (typeof v === 'object' ? JSON.stringify(v, null, 2) : v)).join(', ');
            } else {
                return JSON.stringify(value, null, 2);
            }
        } else if (value == null) {
            return 'N/A'; // Handle null values
        } else {
            return value.toString();
        }
    }

    // Function to print details
    function printDetails(details, indent = 0) {
        Object.keys(details).forEach(key => {
            // Exclude 'id' and 'status' fields
            if (!key.toLowerCase().includes('id') && key.toLowerCase() !== 'status') {
                const label = key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
                let value = details[key];

                pdf.setFont("helvetica", "bold");
                pdf.text(`${' '.repeat(indent)}${label}:`, margin, y);
                pdf.setFont("helvetica", "normal");

                if (typeof value === 'object' && value !== null) {
                    y += lineHeight;
                    checkPageBreak();
                    if (Array.isArray(value)) {
                        value.forEach((item, index) => {
                            pdf.text(`${' '.repeat(indent + 2)}[${index + 1}]`, margin, y);
                            y += lineHeight;
                            checkPageBreak();
                            printDetails(item, indent + 4);
                        });
                    } else {
                        printDetails(value, indent + 4);
                    }
                } else {
                    pdf.text(formatValue(value), margin + 80, y);
                    y += lineHeight;
                    checkPageBreak();
                }
            }
        });
    }

    // Add application title
    pdf.setFontSize(16);
    pdf.setFont("helvetica", "bold");
    pdf.text(applicationTitle, margin, y);
    y += 15;

    pdf.setFontSize(12);
    pdf.setFont("helvetica", "normal");

    printDetails(details);

    return y;
}
