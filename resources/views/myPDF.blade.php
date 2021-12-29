<!DOCTYPE html>
<html>
<head>
    <title>Agreement</title>
</head>
<body>
  <img src="{{ $AgreementImg}}">
  <br/>
<h2 style="text-align: center;">FREELANCE SERVICES</h2>
<h1 style="text-align: center;"><b>AGREEMENT</b></h1>
    <p>Search Jobs For You(Freelancing services)<br> <strong>BETWEEN</strong></p>

    <p>{{ $UserData->UserName}}(Second Party)</p>
    <p>Date:{{ $UserData->created_at}}</p>


    <img src="{{ storage_path('signture/SIGN.jpg') }}" style="width: 100px;  text-align:left;">
    <p>(ON BEHALF OF SEARCH JOBS FOR YOU)</p>
    @if($UserSignture)
    {{-- <img src="{{ storage_path($UserSignture) }}" style="width: 100px;  text-align:left;"> --}}
    <img src="{{ $UserSignture }}" style="width: 100px;  text-align:left;">
    @endif
    <p>(Mr/Ms. {{ $UserData->UserName}})</p>
    <!-- <p>(Mail Id: {{$UserData->UserEmail}})</p> -->
    <h2 style="text-align: center;">CONTRACT FOR FREELANCE SERVICES</h2>
    <p>This Agreement is made for availing Freelance services from Second Party:<br>
      M/s Search Jobs For You, having its office at 305, 4 floor, highfield ascot, vip road, vesu 395007 (Hereinafter referred to as the “Freelancing services”)<br>
      AND<br>
M/s. 	 {{ $UserData->UserName}}                                          , residing at –   {{ $UserData->UserAddress}}                                                                   . (Hereinafter referred to as the “Second Party”)

</p>
@if($AgreementText || $AgreementText != null)
{!! $AgreementText !!}
@else
<h2 style="text-align: center;">1.	Background:</h2>
  <p>WHEREAS, the Freelancing services is an Organization engaged in providing man power facilities or outsourcing, especially to the Companies which are into IT services and data entry related line of work. </p>
  <p>AND WHEREAS the Freelancing services has entered with a firm launching its new JOB PORTAL and has represented itself that it has an expertise in the area of providing Man Power/Freelancers to the Companies which are into IT services and other works related to data processing, calculation, counting, estimation, intelligence, computation, analysis, programming, segregation, and all other IT enabled services.</p>
  <p>Whereas, the Second Party is an individual and a Freelancer who is willing to provide its services to the Job Portal Company, via medium of Freelancing services in relation with IT & all data related work which is to be provided by the Freelancing services.</p>
  <p><strong>It is hereby agreed between the Parties as under:</strong></p>
  <p>1.1	That both the Parties has decided with sweet will and free consent to work together for gains.</p>
  <p>1.2	The purpose of Parties behind this Agreement is to work for gain in relation to the Freelance services.</p>
  <p>1.3	That the Freelancing services is into providing Man Power/Free Lancers and is focused to provide it’s services to the Partners/Associates (M/s Future Jobs.) on a service cum work basis and in lieu of that is in quest of Freelancers who are experienced and well accompanied with technical knowhow of IT and data entry related services.</p>
<h3 style="text-align:left;">2.	SCOPE OF WORK:</h3>
<p>a)	The Freelancing services shall provide details of the resumes through the login credentials shared through SMS Or Email.</p>
<p>b)	The Second Party undertakes to provide freelance services in relation to the Data set out on the said files and/or any such Other Convenient Format, received by/from Portal of the Freelancing services, as visible, in a Format known as that of a ‘Documents’, in the same Language as visible in the said IMAGE Files, and in the same style and upload the same on the same Portal, within the Stipulated time and with such Accuracy as is Outlined further in this Agreement.</p>
<p>c)	The Second Party undertakes to take care of their systems in which they will work as Freelancing services cannot be held responsible for the same as there will be no backup option available in case of system failure.</p>
<p>d)	The Second Party further Represents to the Freelancing services, the time for the Completion of the said data entry related services as mentioned in this Agreement, shall Commence Immediately upon logging on the portal OR if the Commencement Date is mentioned in the said Communication, from such date, and it shall Continue to Access its said Portal/E-Mail as provided in the Records of the Freelancing services, as frequently as necessary for the said Purpose.</p>
<p>e) That the Second Party agrees to pay Rs. 6000 as charges for membership, Portal charges, GST
and other applicable charges in case of failure to submit complete workload or to provide workload on
time with desired accuracy. This membership will include Jobs Vacancy information in Pan India
through our Social Media platform.</p>
<p>f) That in lieu/consideration of the above Fees/charges, the Freelancing services will provide agreement which
will be valid for 1 month but project duration will be 7 days as mentioned. It also pertinent to mention
here that one project will contain 600 CV's in one project. In case, if second party requires extension
to complete the project then extension is available at nominal charges. In case of medical emergency we can provide extension but medical documents are required.</p>
<p>g)	That the Freelancing services will give 600 resumes in PDF or any other image format on the Company’s Portal. On the Portal itself, the details of the work of data processing are provided, which will clearly mention the details, as in what & how is to be processed.</p>
<p>h)	That the Second Party has to fill the details which are mentioned in the Resume or if the information which is/are not available in the Resumes, NA is to be written. Like this, maximum 600 resumes can be processed in a month. However, the compensation will be made in accordance with payment slab of Schedule 8. </p>
<p>i) All the resumes that are processed, will go through a quality check, wherein, it will go under the
scanning for evaluation process to check whether all the data that should be extracted is been
extracted from the resume properly or not because we are selling the data in the open market which requires verified leads. Submission will go for checking when second party will complete all the 600 resumes.</p>
<p>j)	Payment to be made maximum within 7 days of each calendar month, from the QC report, which will be given usually within 5 days of submission of the work.  </p>
<p>k)	That the Freelancing services gets all these resumes from Future Jobs.</p>
<p>l)	In case of any dispute second party must contact to the Freelancing services and if they are unable to resolve their problem, they can proceed legally. Second party can communicate through info@searchjobsforyou.com or on customer care numbers provided.</p>
<h3 style="text-align:left;">3.	General Terms & Conditions:</h3>
<p>The parties have discussed the freelance services to be provided to the Freelancing services and have agreed that the Second party shall take up the said work for the Freelancing services and have agreed to enter into an agreement for mutual benefits on following general terms:</p>
<p>a)	That the Second party shall take up the Freelance work at its level on behalf of the Freelancing services.</p>
<p>b)	That the Second party shall use all the ways and means in this regard for the freelance services to be provided to the Freelancing services at its own cost.</p>
<p>c)	That the Second party shall put in it’s all the experience and skills and quality enhancement of the services in competition of the work provided by the Freelancing services and shall take effective steps for the same.</p>
<p>d)	The Second party is providing all the Freelance/professional services with regard to this Agreement to the Freelancing services and is entitled to claim the charges against the services rendered in accordance with the Agreement and the Schedule is attached with this Contract for the same reason. </p>
<p>e) That the Second Party agrees to pay Rs. 5,000 as charges for membership, Portal charges, GST and other applicable charges in case of failure to submit complete workload or to provide workload on time with desired accuracy. This membership will include Jobs Vacancy information in Pan India through our Social Media platform.</p>
<p>f) That in lieu/consideration of the above Fees/charges, the Freelancing services will provide agreement which
will be valid for 1 month but project duration will be 7 days as mentioned. It also pertinent to mention
here that one project will contain 600 CV's in one project. In case, if second party requires extension 
to complete the project then extension is available at nominal charges.</p>
<p>g)	That the present Agreement covers only the Freelance services to be given in relation to the data entry related work to the Freelancing services by the Second Party and no other business or fiduciary relationship between the parties shall be created under this Agreement in any form whatsoever.</p>
<p>h)	That the services required by Freelancing services from Second Party are Freelance services. </p>
<p>i)	That the Second Party will complete the data entry related work directly on the Portal provided by the Freelancing services. However, after completion of the said work it will be filtered or go through a quality check process and on the basis of that report the actual correct work will be compensated by the Freelancing services or it’s Associates/Partners.</p>
<p>j)	The Freelancing services will provide the Quality Check Report to the Second Party of each & every work completed by the Second Party in lieu of this Agreement. </p>
<p>k)	That both the parties will complete their part of work and consideration with best possible efforts and with utmost diligence.</p>
<p>l)	The Second Party will strictly undertake not to communicate or allow to be communicated to any person or divulge in any way any information relating to the ideas, concepts, know-how, techniques, data, facts, figures and all information whatsoever concerning or relating to the said Data. Disclosure of any part of the information or data to parties not directly involved in providing the services requested could result in pre-mature termination of the contract. The Freelancing services, apart from blacklisting the Second Party, can and may initiate legal action against the successful bidder for breach of trust.</p>
<p>m) This Contract does not create any employee, agency or partnership relationship, and/or any other similar relationship of any kind.</p>

<h3 style="text-align:left;">4.	TIMEFRAME FOR COMPLETION OF TRANSCRIPTION:</h3>
<p>The Second Party shall complete the services of the said Data entry work in Seven(7) days TAT period, i.e., maximum 600 resumes can be completed within a period of 7 days. The Second Party alone shall be responsible for the maintenance of Hardware and Personnel for such timely services and no excuse of whatsoever Nature shall be entertained for delay in Supply of services, since Time is the Essence of this Contract.</p>
<h3 style="text-align:left;">5.	DURATION OF THE CONTRACT:</h3>
<p>The Present Contract shall be in force for 1 month membership. The said Contract shall come to an End at the Expiry of the said Period and may be renewed by Mutual Consent and on such Revised Terms agreed between the Parties and on Payment of Processing Charges for another Project by the Second Party.</p>
<p><strong>7.  Confidentiality:</strong></p>
<p>-?Confidential Information? refers in this Agreement to any information - technical, commercial or of any other nature (including any information regarding the identity of a customer of Freelancing services and all other information attributable to the customer?s business or systems) - regardless of whether or not such information has been documented, with the exception of information that is or becomes publicly known other than by the Second Party?s breach of the provisions of this Agreement.</p>
<p>-The Second party undertakes not to use Confidential Information or other information, such as software, etc., obtained within the scope of this Agreement for any other purpose or in any other context than to carry out its specific assignments under this Agreement. Furthermore, the Second Party is prohibited from using Confidential Information obtained within one specific assignment under this Agreement in order to carry out another specific assignment under this Agreement, unless otherwise expressly agreed within the scope of the latter assignment.</p>
<p>-The Second Party undertakes under this Section that this shall also apply to the Second Party?s employees, Associates and consultants. The Second party shall ensure that such employees or consultants that are likely to come in contact with Confidential Information sign separate
/confidentiality undertakings on the same terms and condition.
</p>
<h3 style="text-align:left;">8. TERMS OF PAYMENT AND COMPENSATION:</h3>
<p><strong>The Payment Terms for each of the Plans shall be as Under:</strong></p>
<p>-The payment for every resume will be INR 25 if more then 535 resumes are accurate and not having a single mistake compulsory for the
payment and compensation. If your accurate resumes are below 535 then then INR 2 will be given per
accurate resume but completion of project is mandatory i.e. 600 resumes. In case of non submission also, second
party will receive INR 1/- per resume for the entries which have been made.</p>
<p>-The Entire such Payment Payable by the Freelancing services to the Second Party, shall be made within maximum 7 days of the Receipt of the Accuracy Report.</p>
<p>-In each plan the payment shall be made only for the accurate data processing of Resumes. Any Inaccurate data processing will not qualify for the payment regardless of number of errors found in that page, more or less.</p>
<h3 style="text-align:left;">9.	DETERMINATION OF ACCURACY:</h3>
<p>-The accuracy will be determined per data processing of Resumes. If any Mistake is found such as Spelling error, Punctuation error, Extra Word, Missing word, Extra Space, Space Missing, Extra Enter or Enter Missing, then that form will be considered as Inaccurate resume and hence if accuracy falls below 90% then no payment shall be processed.</p>
<p>-The Test of the Accuracy shall be made by a determining Centre appointed by the Party of the Freelancing services?s Associate/Partner (Search Jobs For You) and the Report of such Accuracy subject to procedure outlined below, would be Final and Conclusive, with no room for Disputing the Veracity of the same by the Party of the Second Part.</p>
<h3 style="text-align:left;">10. PROCEDURE FOR GENERATION OF ACCURACY REPORT:</h3>
<p>-The Determining Centre personnel shall check all the data processing of resumes. After an error is found in a particular resume the Centre personnel shall list that as inaccurate and start checking the next resume.</p>
<p>-All the errors in the whole resume will not be shown in the Accuracy Report.</p>
<p>-Once all data processing of resumes are checked, the final Accuracy Report shall be generated.</p>
<h3 style="text-align:left;">11.	TECHNICAL SPECIFICATIONS FOR DATA RELATED WORK:</h3>
<p>-The Font used in Data shall be ?default font of portal? Size default, irrespective of the Font used in the IMAGE.<br/>
-No ?Justification? of Transcribed Text shall be made.<br/>
-The Data shall be an Exact Replica of the IMAGE in terms of a Split in a Word or the End of a line.<br/>
-Accent Characters shall be typed as Normal Characters.<br/>
-Transcribed text shall be in its normal Style ? ?Bold? or ?Italics? shall not be used.<br/>
-Shortcut keys and the character mapping should not be used.<br/>
-All the fields in the forms should be typed, any field should not be left blank.<br/>
-No grammatical rules should be applied.<br/>
-Give one space between two words if applicable in the data.<br/>
-A resume will not be edited after 48 hours of submission on the portal.<br/>
- It will be locked till the submission date.<br/>
</p>
<h3 style="text-align:left;">12.	ERRORS WARRANTING AUTOMATIC REJECTION & CONTRACT TERMINATION:</h3>
<p>-Submission of an Incomplete resume, incomplete submission or not achieving the desired accuracy.<br/>
-Use of any third Party Software including but not limited to those pertaining to conversion of data, extraction or of any other nature whatsoever? including but not limited to ?Microsoft Office?.<br/>
-Accent Characters used in the Transcribed Data File.<br/>
-Upon any Image or bugs being found in the Transcribed Data.<br/>
-Use of a Font/Color other than that specified.<br/>
-Upon any ?Hyperlinks? being found in the Transcribed Data.<br/>
-Submission beyond the Stipulated Deadline.<br/>
-Use of shortcut keys and character mapping.<br/>
-Dividing the transcribed data into Paragraphs.<br/>
-If the grammatical rules are applied so as to modify the existing text in any manner.<br/>
</p>
<h3 style="text-align:left;">13.	Severability:</h3>
<p>-The various provisions of this ?Freelance services Contract? are severable and if any provision is held to be invalid or unenforceable by any court of competent jurisdiction then such invalidity or unenforceability shall not affect the remaining provisions of this Services Agreement.</p>
<h3 style="text-align:left;">15. Governing Law and Arbitration:</h3>
<p>-This Agreement shall be governed by laws of India. Any dispute arising in relation to this Agreement shall first be resolved through amicable way i.e. amicable talks and then arbitration under the Arbitration & Conciliation Act, 1996.</p>
<p>-The Freelancing services shall notify an Arbitrator to the Second Party. Provided that none of such arbitrators shall have represented or had a business connection with the Freelancing services previously.</p>
<p>-The arbitration shall be held in Surat and conducted in English language. Every order of the arbitrator shall be justified by reasons in writing.</p>
<p>-Notwithstanding the foregoing, the Freelancing services shall be entitled to obtain such injunctive or equitable relief as may be necessary by any court of competent jurisdiction including any court having jurisdiction over a place where the Second Party is having presence.</p>
<h2 style="text-align:left;">WAIVER</h2>
<p>The Second Party expressly undertakes to submit as per the timeframe and accuracy clauses and should the Second Party fail in either of the said parameters, in terms of not achieving Minimum Accuracy for each stage of work as set out in the Schedule herein, or delivering the same beyond the timeframe set out elsewhere herein, it expressly undertakes that the said submission shall have to be reworked entirely and that the Second Party does not have any rights whatsoever on the said submission and expressly waives any rights thereupon.</p>
<p>That this Agreement has been drafted upon the facts and instructions furnished and with free consent & will of both the Parties. Both the parties have read and understood the contents of this Agreement prior to the execution of the same.</p>
<p><strong> WITNESS, WHERE OF</strong> the Parties have set their hand here under,</p>
@endif
<img src="{{ storage_path('signture/SIGN.jpg') }}" style="width: 100px;  text-align:left;">
<p>(ON BEHALF OF SEARCH JOBS FOR YOU)</p>
@if($UserSignture)
<img src="{{ storage_path($UserSignture) }}" style="width: 100px; text-align:left;">
@endif
<p>(Mr/Ms. {{ $UserData->UserName}})</p>
<h2 style="text-align:center;">DECLARATION / UNDERTAKING BY THE FREELANCER</h2>
<p>-I assure that the sign which is done digitally is done by me with full responsibility. I am liable to pay the portal charge, if I don’t complete the task within stipulated time or with desired accuracy.</p>
<p>-In case of any dispute I will contact on the official email ID provided by the organization i.e. info@searchjobsforyou.com</p>
<p>-Not to disclose the system password to anyone.</p>
<p></p>
<p>-Not to leave my PC unattended. I would be personally responsible for its misuse of any nature when I am away.</p>
<p>-Not to share Company's confidential information with anyone. Nor proprietary / confidential information.</p>
<p>-I assure that the sign which is done digitally is done by me with full responsibility. I am liable to pay the portal charge, if I don’t complete the task within stipulated time or with desired accuracy.</p>
<p>-To pay the portal charges if work not completed as per the contract.</p>
<p>-To have my System scanned for virus once a week.</p>
<p>-To take print out of mails only when absolutely necessary.</p>
<p>-To always try and ensure that the attachment when required to be sent with mails are below 10 MB size.</p>
<p>-To always send documents in pdf format.</p>
<p>-To send images, whenever required, only in JPEG/PNG format.</p>
<p>-Not to use any type of software from any source at any time whatsoever. If required for official purpose at any time, approval from IT department will be taken in writing to make sure such software are scanned properly before use, and such software will be downloaded legally and with IT department's consensus.</p>
<p>-Password given should be confidential.</p>
<p><strong>-I fully agree and accept that it is my personal responsibility to adhere to the Company's I.T. Policy and any amendment / modification thereof and to comply with all of the provisions stated therein in true letter and spirit. I understand and accountable for any consequence or any misuse of system. I further undertake to abide by the I.T. Policy guidelines as a condition of my employment and my continuing employment in the Company.</strong></p>
<p>NOTE - IT IS THE DUTY OF SECOND PARTY TO TAKE THE PRINT OUT OF DECLARATION ALSO SELF ATTEST THE COPY AND SEND IT THROUGH MAIL FOR ACKNOWLEDGEMENT.</p>
<br/>
<br/>
<p>Freelancer Signature:  <br/>@if($UserSignture)<img src="{{ $UserSignture }}" style="width: 100px;  text-align:left;"> @endif</p>
</body>
</html>