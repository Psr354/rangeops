# 🛡️ RangeOps: Enterprise Purple Team Cyber Range

![Docker](https://img.shields.io/badge/Docker-Compose-blue?logo=docker)
![Wazuh](https://img.shields.io/badge/Wazuh-SIEM%2FXDR-orange?logo=wazuh)
![Bash](https://img.shields.io/badge/Bash-Telemetry%20Bridge-green?logo=gnu-bash)
![Status](https://img.shields.io/badge/Status-Active-success)
![License](https://img.shields.io/badge/License-MIT-yellow.svg)

**RangeOps** is an enterprise-grade **Purple Team homelab cyber range** designed to bridge the gap between **Red Team exploitation** and **Blue Team detection engineering**.

Built from the ground up, this environment provides a realistic playground to practice offensive security while simultaneously collecting, analyzing, and engineering defensive telemetry.

---

# 🏛️ Architecture Overview

RangeOps is built around four main pillars:

- 🛡️ **SIEM / XDR Monitoring (Wazuh)**
- 👑 **King of the Hill (KotH) Arena**
- 💻 **Boot2Root (B2R) Scenarios**
- 🚩 **CTF Lab Ecosystem**

---

# 🛡️ 1. SIEM Integration — Wazuh XDR

> The Blue Team Command Center

Monitoring containers is challenging because Docker isolates processes, filesystems, and networks.

RangeOps solves this problem using a custom **Docker Telemetry Bridge**.

---

## Agentless Container Monitoring

Uses:

- Docker Shared Volumes
- Bash Shell Wrappers
- `PROMPT_COMMAND`

to forward interactive shell activity from isolated containers into Wazuh Manager.

Example telemetry:

```bash
whoami
id
sudo -l
bash -p
cat /root/king.txt
```

---

## Custom Detection Engineering

Includes:

- Custom Wazuh decoders
- OSRegex / PCRE2 patterns
- Custom detection rules

Severity levels:

```
Level 3  → Informational
Level 12 → Privilege Escalation
Level 14 → Critical Incident
```

Mapped against:

- MITRE ATT&CK
- Enterprise attack kill-chain

---

## Real-Time Alerting

Detects:

- Suspicious shell activity
- Privilege escalation
- File modification
- Persistence attempts

Example:

```text
Attacker modifies:

/root/king.txt

↓

Wazuh Alert

↓

SOC Investigation
```

---

# 👑 2. King of the Hill Arena

> Competitive Persistence & Privilege Escalation

A volatile multi-attacker environment designed to simulate attacker competition.

---

## Objective

Attackers must:

1. Gain initial access
2. Escalate privileges
3. Maintain persistence
4. Capture the throne

Target:

```bash
/root/king.txt
```

---

## Attack Simulation

Example:

```bash
ssh player@<TARGET_IP> -p 2222
```

Privilege escalation:

```bash
/usr/local/bin/privshell -p
```

Claim throne:

```bash
echo "PLAYER_WINS" > /root/king.txt
```

---

## Purple Team Detection

When the throne is captured:

```
File Modification Detected

↓

Wazuh Level 14 Emergency Alert

↓

SOC Response
```

---

# 💻 3. Boot2Root (B2R) Scenarios

> End-to-End Enterprise Exploitation & System Compromise

Curated real-world vulnerable environments designed to simulate a complete **attack kill-chain**, starting from initial access until full **OS-level compromise**.

The goal:

- Initial foothold
- Exploitation
- Post exploitation
- Privilege escalation
- Detection engineering

---

# Current B2R Targets

## Jenkins CI/CD — CVE-2018-1000861

**Enterprise CI/CD Remote Code Execution**

Attack chain:

```text
Unauthenticated Access
        ↓
ACL Bypass
        ↓
Groovy ASTTest Compile-Time RCE
        ↓
Command Execution
        ↓
Privilege Escalation
```

Techniques:

- Jenkins misconfiguration abuse
- Groovy exploitation
- CI/CD security testing
- Linux privilege escalation

---

## Apache Tomcat WebDAV — CVE-2017-12615

**Java WebDAV Upload Bypass**

Attack chain:

```text
HTTP PUT Abuse
        ↓
Extension Validation Bypass
        ↓
JSP Upload
        ↓
Remote Code Execution
        ↓
OS Pivot
```

Techniques:

- WebDAV exploitation
- File upload bypass
- JSP shell
- Remote command execution

---

## Image Provenance

Powered by:

https://github.com/vulhub/vulhub

Used to simulate historical enterprise vulnerabilities without manually compiling vulnerable software.

---

# 🚩 4. CTF Lab Ecosystem

> Web Exploitation, API Hacking, & Classic Vulnerability Training

Dedicated environments for practicing:

- Web exploitation
- API security
- Logic flaws
- Application vulnerabilities

The lab follows a Purple Team workflow:

```text
Attack Application
        ↓
Generate Artifacts
        ↓
Analyze Logs
        ↓
Detect Through Wazuh
        ↓
Improve Rules
```

---

# Current CTF Targets

---

## OWASP Juice Shop

**Modern Web Application Security Training**

Focus:

- API security
- Authentication flaws
- JWT vulnerabilities
- Client-side attacks

Examples:

```text
SQL Injection
        ↓
Authentication Bypass

JWT Weakness
        ↓
Token Manipulation

XXE
        ↓
Data Exfiltration

NoSQL Injection
        ↓
Database Abuse
```

---

## DVWA

**Classic Web Pentesting Environment**

Training for fundamental vulnerabilities.

Covered:

- Reflected XSS
- Stored XSS
- Blind SQL Injection
- Local File Inclusion
- Remote File Inclusion
- Command Injection

---

# 🛠️ Tech Stack

| Component | Technology |
|---|---|
| SIEM / XDR | Wazuh 4.x |
| Container | Docker + Docker Compose |
| Host OS | Debian 13 / Ubuntu 22.04 |
| Network | ZeroTier + UFW |
| Telemetry | Bash + PROMPT_COMMAND |
| Targets | Vulhub + Custom Docker Images |

---

# 🚀 Installation

## Clone Repository

```bash
git clone https://github.com/Psr354/rangeops.git

cd rangeops
```

---

## Deploy Wazuh

```bash
cd wazuh-docker/single-node

docker compose up -d
```

Wait until services initialize.

---

## Deploy KotH

```bash
cd ../../koth-arena

docker compose up -d --build
```

KotH endpoints:

```text
http://<HOST_IP>:8080
ssh player@<HOST_IP> -p 2222
```

## Deploy SOC Dashboard

```bash
cd ../soc-dashboard

docker compose up -d
```

SOC dashboard:

```text
http://<HOST_IP>:8090
```

---

# 🎯 Purple Team Workflow

## 🔴 Red Team

Attack:

```bash
ssh player@<TARGET_IP> -p 2222
```

Privilege escalation:

```bash
/usr/local/bin/privshell -p
```

Objective:

```bash
echo "PLAYER_WINS" > /root/king.txt
```

---

## 🔵 Blue Team

Open:

```text
https://<HOST_IP>:8443
```

Go to:

```text
Threat Hunting
```

Query:

```kql
rule.id:"100051" OR rule.id:"100052"
```

Expected:

```
Privilege Escalation Alert

King File Modification Alert
```

RangeOps KotH telemetry:

```text
100100  Web diagnostics page requested
100101  Scoreboard requested
100102  Web command execution detected
100106  Vulnerable command runner requested
100107  SSH connection attempt detected
100108  SSH failed password detected
100109  SSH successful password login detected
100103  Interactive shell command captured
100104  King file interaction detected
100105  Privilege escalation helper executed
```

Collected files:

```text
koth-arena/koth-logs/apache-access.log
koth-arena/koth-logs/apache-error.log
koth-arena/koth-logs/ssh.log
koth-arena/koth-logs/web-requests.log
koth-arena/koth-logs/web-commands.log
koth-arena/koth-logs/commands.log
```

Dashboard query:

```kql
agent.id: "000" AND rule.groups: "rangeops"
```

---

# 📂 Directory Structure

```text
rangeops/

├── wazuh-docker/
│
├── koth-arena/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── index.php
│   ├── scoreboard.php
│   ├── koth-tracker.sh
│   └── koth-logs/
│
├── soc-dashboard/
│   ├── docker-compose.yml
│   ├── dashboard.php
│   └── index.php
│
├── vulhub/
│
├── .gitignore
│
└── README.md
```

---

# 🤝 Contributing

Contributions are welcome.

Add new:

- CVE scenarios
- Detection rules
- CTF machines
- Telemetry integrations


Create branch:

```bash
git checkout -b feature/new-scenario
```

Commit:

```bash
git commit -m "feat: add new scenario"
```

Push:

```bash
git push origin feature/new-scenario
```

Open Pull Request.

---

# 📄 License

This project is licensed under the MIT License.

See:

```
LICENSE
```

for details.
