# Denial of Wallet Attack Mitigations

## Billing Alerts
- One strategy commonly used is to set multiple alarms that you expect to trigger throughout the month.
- When an alert is triggered unexpectedly, you know something is wrong.

## Service Quotas
- Coding mistakes can cause infinite loops which could provision resources repeatedly or trigger Lambda infinitely. 
- Service Quotas help mitigate the same.
- These limits also play a role in mitigating the impact of someone using your account for bitcoin mining. Without these limits an attacker could try to spin up a million EC2s, but due to these limits, the attacker might only spin up a few dozen EC2s.

## Compromised Access
- Running an arbitrary API call, or deleting files, the attacker has compromised access.
- You can mitigate both of those scenarios by implementing least privilege on services, enforcing MFA, and implementing SCPs.
- Mitigate by limiting the blast radius through the use of multiple AWS accounts and WORM backups through the use of S3 Object Lock.
- Beware of S3 Object Lock, even root user can't delete object locked files. API call is `s3:PutObjectRetention` so `s3:Put*` can write and lock files as well.

## Auto-scaling
- AWS Shield is AWS's DDoS solution. 
- Standard and Advanced.
- Standard prevents Layer 3 and 4 attacks on CloudFront and Route53 for free.
- Advanced is $3K/mo plus an additional per GB cost for data transferred out. Also includes AWS DDoS Response Team.
- The biggest benefit of Shield Advanced is that in the event of a DDoS where you have to scale up services to handle it, you can get credits back to your account for that additional cost imposed.

## Architecture Choices
- Allowing users to directly upload files to your s3 bucket is not advisable.
- One attack that can be performed, is to upload large numbers of files or large files. `aws s3 sync` can be exploited by setting a public bucket as the source, and the victim bucket as the destination.
- You need to ensure you can differentiate and block specific users that may be abusing your service.
- Restrict the file name and size so that single users are not uploading many files or a single large file. To do this, you should use presigned-posts which allow you to use POST policies where you can specify the name and size limits.
- Another attack is to partially upload files. Most applications will only take action once a file has completely uploaded.
- Mitigate this by using a lifecycle policy to abort incomplete multi-part uploads.